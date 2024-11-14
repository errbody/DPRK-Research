using System;
using System.Net.Sockets;

namespace RevClient.Networking
{
	// Token: 0x02000004 RID: 4
	public class CopyStream
	{
		// Token: 0x06000018 RID: 24 RVA: 0x00003210 File Offset: 0x00001410
		public CopyStream(TcpClient source, TcpClient dest, Action onClose)
		{
			this.m_destClient = dest;
			this.m_onClose = onClose;
			this.m_sourceClient = source;
			this.m_sourceStream = this.m_sourceClient.GetStream();
			this.m_destStream = this.m_destClient.GetStream();
			byte[] array = new byte[2048];
			this.m_sourceStream.BeginRead(array, 0, array.Length, new AsyncCallback(this.EndSourceRead), array);
		}

		// Token: 0x06000019 RID: 25 RVA: 0x00003284 File Offset: 0x00001484
		private void EndSourceRead(IAsyncResult ar)
		{
			try
			{
				byte[] array = (byte[])ar.AsyncState;
				int num = this.m_sourceStream.EndRead(ar);
				if (num > 0)
				{
					this.m_destStream.BeginWrite(array, 0, num, new AsyncCallback(this.EndDestWrite), null);
					this.m_sourceStream.BeginRead(array, 0, array.Length, new AsyncCallback(this.EndSourceRead), array);
				}
				else
				{
					this.m_sourceStream.Close();
					this.m_sourceClient.Close();
					this.m_onClose();
				}
			}
			catch
			{
				this.m_sourceStream.Close();
				this.m_sourceClient.Close();
				this.m_onClose();
			}
		}

		// Token: 0x0600001A RID: 26 RVA: 0x00003344 File Offset: 0x00001544
		private void EndDestWrite(IAsyncResult ar)
		{
			try
			{
				this.m_destStream.EndWrite(ar);
			}
			catch
			{
				this.m_sourceStream.Close();
				this.m_sourceClient.Close();
				this.m_onClose();
			}
		}

		// Token: 0x04000013 RID: 19
		private readonly NetworkStream m_destStream;

		// Token: 0x04000014 RID: 20
		private readonly TcpClient m_destClient;

		// Token: 0x04000015 RID: 21
		private readonly Action m_onClose;

		// Token: 0x04000016 RID: 22
		private readonly NetworkStream m_sourceStream;

		// Token: 0x04000017 RID: 23
		private readonly TcpClient m_sourceClient;
	}
}
