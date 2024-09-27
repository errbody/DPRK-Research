import requests

def search_github_code(query, token):
    headers = {
        'Accept': 'application/vnd.github.v3+json',
        'Authorization': 'token {}'.format(token)
    }
    params = {
        'q': query
    }
    response = requests.get('https://api.github.com/search/code', headers=headers, params=params)
    ret = {}
    if response.status_code == 200:
        results = response.json()['items']
        for result in results:
            if result['repository']['full_name'] != "0x50D4/0x50d4.github.io": # PassList
                ret[result['repository']['full_name']] = result['path']
    else:
        print('Error:', response.status_code)
    return ret

token = "" # Your Github Token

# Example
search_term = '/* learn more: https://github.com/testing-library/jest-dom // @testing-library/jest-dom library provides a set of custom jest matchers that you can use to extend jest. These will make your tests more declarative, clear to read and to maintain.*/ Object'
#search_term = 'Object.prototype.toString,Object.defineProperty,Object.getOwnPropertyDescriptor;const t="base64",c="utf8",a=require("fs"),$=require("os")'
#search_term = 'Object.prototype.toString,Object.defineProperty,Object.getOwnPropertyDescriptor;const '
#search_term = 'const t="base64",c="utf8",'
#search_term = "Object.getOwnPropertyDescriptor;const "
#search_term = 'const cBase64="base64",cUtf8="utf8",'


ret = search_github_code(search_term, token)
cnt = 0
for repo in ret:
    print("Repository : https://github.com/" + repo)
    print("\tPath : %s" % ret[repo])
    print()
    cnt += 1
print("Total Cnt : %d" % cnt)