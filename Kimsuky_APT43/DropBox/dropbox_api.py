import requests
import os
import hashlib

def refresh_dropbox_token(app_key, app_secret, refresh_token):
    url = "https://api.dropboxapi.com/oauth2/token"
    headers = {
        "Content-Type": "application/x-www-form-urlencoded",
    }

    data = {
        "grant_type": "refresh_token",
        "client_id": app_key,
        "client_secret": app_secret,
        "refresh_token": refresh_token,
    }

    response = requests.post(url, headers=headers, data=data)

    if response.status_code == 200:
        # Request was successful
        access_token = response.json().get("access_token")
        print("Successfully refreshed access token!")
        return access_token
    else:
        print("Error refreshing token. Status code:", response.status_code)
        print("Response content:", response.text)
        return None

def list_files_recursive(access_token, folder_path=""):
    url = "https://api.dropboxapi.com/2/files/list_folder"
    headers = {
        "Authorization": f"Bearer {access_token}",
        "Content-Type": "application/json",
    }

    data = {
        "path": folder_path,
        "recursive": True,
        "include_media_info": False,
        "include_deleted": False,
        "include_has_explicit_shared_members": False,
        "include_mounted_folders": True,
        "include_non_downloadable_files": True,
    }

    response = requests.post(url, headers=headers, json=data)

    if response.status_code == 200:
        # Request was successful
        entries = response.json().get("entries", [])
        file_names = [entry["path_display"] for entry in entries if entry[".tag"] == "file"]
        return file_names
    else:
        print("Error listing files. Status code:", response.status_code)
        print("Response content:", response.text)
        return None

def download_file(access_token, file_path, output_path="."):
    url = "https://content.dropboxapi.com/2/files/download"
    headers = {
        "Authorization": f"Bearer {access_token}",
        "Dropbox-API-Arg": f'{{"path": "{file_path}"}}',
    }

    response = requests.post(url, headers=headers)

    if response.status_code == 200:
        # Request was successful, save the file locally
        local_path = os.path.join(output_path, file_path[1:])  # Removing leading '/'
        local_dir = os.path.dirname(local_path)

        if not os.path.exists(local_dir):
            os.makedirs(local_dir)

        output_file_path = os.path.join(output_path, file_path[1:])
        output_file_path = output_file_path.replace(":", ";")
        with open(output_file_path, "wb") as output_file:
            output_file.write(response.content)
        
        if output_file_path.find(".txt") != -1 or output_file_path.find(".bin") != -1:
            md5_hash = hashlib.md5()
            with open(output_file_path, "rb") as file_to_hash:
                for chunk in iter(lambda: file_to_hash.read(4096), b""):
                    md5_hash.update(chunk)
            
            hash = md5_hash.hexdigest()
            print(f"{hash} ({file_path})")
        return True
    else:
        print(f"Error downloading file '{file_path}'. Status code:", response.status_code)
        print("Response content:", response.text)
        return False
def download_all_files(access_token, files, output_path="."):
    for file_path in files:
        download_file(access_token, file_path, output_path)


app_key = "1hhq5qgbo6fwzg7"
app_secret = "1ko159sblasx4qs"
refresh_token = "8TBfuRQCFkYAAAAAAAAAAcrQOUOuRsrNRLYRwS3nscA19vze08QuUtFVQ35GcrXW"

if refresh_token:
    print("Your Dropbox refresh token:", refresh_token)
    refreshed_token = refresh_dropbox_token(app_key, app_secret, refresh_token)

    if refreshed_token:
        print("Your refreshed Dropbox access token:", refreshed_token)
        all_files = list_files_recursive(refreshed_token)

        if all_files:
            print("All files in all folders:")
            for file_name in all_files:
                print(file_name)
            download_all_files(refreshed_token, all_files)
