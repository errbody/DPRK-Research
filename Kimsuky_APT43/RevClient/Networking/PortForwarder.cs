using System;
using System.Collections.Concurrent;
using System.Net.Sockets;
using System.Threading;

namespace RevClient.Networking
{
	// Token: 0x02000006 RID: 6
	public class PortForwarder
	{
		// Token: 0x17000006 RID: 6
		// (get) Token: 0x0600001D RID: 29 RVA: 0x000033C9 File Offset: 0x000015C9
		// (set) Token: 0x0600001E RID: 30 RVA: 0x000033D1 File Offset: 0x000015D1
		private int m_FromPort { get; set; }

		// Token: 0x17000007 RID: 7
		// (get) Token: 0x0600001F RID: 31 RVA: 0x000033DA File Offset: 0x000015DA
		// (set) Token: 0x06000020 RID: 32 RVA: 0x000033E2 File Offset: 0x000015E2
		private int m_ForwardPort { get; set; }

		// Token: 0x17000008 RID: 8
		// (get) Token: 0x06000021 RID: 33 RVA: 0x000033EB File Offset: 0x000015EB
		// (set) Token: 0x06000022 RID: 34 RVA: 0x000033F3 File Offset: 0x000015F3
		private string m_FromIP { get; set; }

		// Token: 0x17000009 RID: 9
		// (get) Token: 0x06000023 RID: 35 RVA: 0x000033FC File Offset: 0x000015FC
		// (set) Token: 0x06000024 RID: 36 RVA: 0x00003404 File Offset: 0x00001604
		private string m_ForwardIP { get; set; }

		// Token: 0x1700000A RID: 10
		// (get) Token: 0x06000025 RID: 37 RVA: 0x0000340D File Offset: 0x0000160D
		// (set) Token: 0x06000026 RID: 38 RVA: 0x00003415 File Offset: 0x00001615
		public ConcurrentDictionary<Guid, ClientInfo> m_Clients { get; set; }

		// Token: 0x06000027 RID: 39 RVA: 0x0000341E File Offset: 0x0000161E
		public PortForwarder(string fromIp, int fromPort, string forwardIp, int forwardPort)
		{
			this.m_Clients = new ConcurrentDictionary<Guid, ClientInfo>();
			this.m_FromPort = fromPort;
			this.m_ForwardPort = forwardPort;
			this.m_FromIP = fromIp;
			this.m_ForwardIP = forwardIp;
		}

		// Token: 0x06000028 RID: 40 RVA: 0x00003450 File Offset: 0x00001650
		private ClientInfo createClientInfo()
		{
			Guid guid = Guid.NewGuid();
			ClientInfo clientInfo = new ClientInfo
			{
				Id = guid,
				SourceClient = new TcpClient(),
				DestClient = new TcpClient()
			};
			this.m_Clients[guid] = clientInfo;
			return clientInfo;
		}

		// Token: 0x06000029 RID: 41 RVA: 0x00003494 File Offset: 0x00001694
		public void StopServer()
		{
			this.m_started = false;
		}

		// Token: 0x0600002A RID: 42 RVA: 0x000034A0 File Offset: 0x000016A0
		public void StartServer()
		{
			this.m_started = true;
			ClientInfo clientInfo = this.createClientInfo();
			while (this.m_started)
			{
				try
				{
					if (!clientInfo.SourceClient.Connected)
					{
						this.Close(clientInfo.Id);
						clientInfo = this.createClientInfo();
						clientInfo.SourceClient.Connect(this.m_FromIP, this.m_FromPort);
					}
					if (clientInfo.SourceClient.Connected && !clientInfo.DestClient.Connected)
					{
						clientInfo.DestClient.BeginConnect(this.m_ForwardIP, this.m_ForwardPort, new AsyncCallback(this.EndConnectWriter), clientInfo);
					}
				}
				catch
				{
					this.Close(clientInfo.Id);
					this.m_started = false;
					break;
				}
				Thread.Sleep(1000);
			}
		}

		// Token: 0x0600002B RID: 43 RVA: 0x00003574 File Offset: 0x00001774
		private void EndConnectWriter(IAsyncResult ar)
		{
			try
			{
				ClientInfo info = (ClientInfo)ar.AsyncState;
				info.DestClient.EndConnect(ar);
				info.SourceToDest = new CopyStream(info.SourceClient, info.DestClient, delegate()
				{
					this.Close(info.Id);
				});
				info.DestToSource = new CopyStream(info.DestClient, info.SourceClient, delegate()
				{
					this.Close(info.Id);
				});
			}
			catch
			{
			}
		}

		// Token: 0x0600002C RID: 44 RVA: 0x0000362C File Offset: 0x0000182C
		private void Close(Guid id)
		{
			try
			{
				ClientInfo clientInfo;
				if (this.m_Clients.TryRemove(id, out clientInfo))
				{
					if (clientInfo.SourceClient.Connected)
					{
						clientInfo.SourceClient.Close();
					}
					if (clientInfo.DestClient.Connected)
					{
						clientInfo.DestClient.Close();
					}
				}
			}
			catch
			{
			}
		}

		// Token: 0x04000019 RID: 25
		public bool m_started;
	}
}
