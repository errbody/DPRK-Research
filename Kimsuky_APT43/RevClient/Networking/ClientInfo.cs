using System;
using System.Net.Sockets;

namespace RevClient.Networking
{
	// Token: 0x02000003 RID: 3
	public class ClientInfo
	{
		// Token: 0x17000001 RID: 1
		// (get) Token: 0x0600000D RID: 13 RVA: 0x000031B9 File Offset: 0x000013B9
		// (set) Token: 0x0600000E RID: 14 RVA: 0x000031C1 File Offset: 0x000013C1
		public Guid Id { get; set; }

		// Token: 0x17000002 RID: 2
		// (get) Token: 0x0600000F RID: 15 RVA: 0x000031CA File Offset: 0x000013CA
		// (set) Token: 0x06000010 RID: 16 RVA: 0x000031D2 File Offset: 0x000013D2
		public TcpClient DestClient { get; set; }

		// Token: 0x17000003 RID: 3
		// (get) Token: 0x06000011 RID: 17 RVA: 0x000031DB File Offset: 0x000013DB
		// (set) Token: 0x06000012 RID: 18 RVA: 0x000031E3 File Offset: 0x000013E3
		public TcpClient SourceClient { get; set; }

		// Token: 0x17000004 RID: 4
		// (get) Token: 0x06000013 RID: 19 RVA: 0x000031EC File Offset: 0x000013EC
		// (set) Token: 0x06000014 RID: 20 RVA: 0x000031F4 File Offset: 0x000013F4
		public CopyStream SourceToDest { get; set; }

		// Token: 0x17000005 RID: 5
		// (get) Token: 0x06000015 RID: 21 RVA: 0x000031FD File Offset: 0x000013FD
		// (set) Token: 0x06000016 RID: 22 RVA: 0x00003205 File Offset: 0x00001405
		public CopyStream DestToSource { get; set; }
	}
}
