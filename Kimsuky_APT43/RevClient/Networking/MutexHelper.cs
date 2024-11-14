using System;
using System.Threading;

namespace RevClient.Networking
{
	// Token: 0x02000005 RID: 5
	public static class MutexHelper
	{
		// Token: 0x0600001B RID: 27 RVA: 0x00003394 File Offset: 0x00001594
		public static bool CreateMutex(string name)
		{
			bool flag;
			MutexHelper._appMutex = new Mutex(false, name, out flag);
			return flag;
		}

		// Token: 0x0600001C RID: 28 RVA: 0x000033B0 File Offset: 0x000015B0
		public static void CloseMutex()
		{
			if (MutexHelper._appMutex != null)
			{
				MutexHelper._appMutex.Close();
				MutexHelper._appMutex = null;
			}
		}

		// Token: 0x04000018 RID: 24
		private static Mutex _appMutex;
	}
}
