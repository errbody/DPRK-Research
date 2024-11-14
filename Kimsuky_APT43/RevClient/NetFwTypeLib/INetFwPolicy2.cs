using System;
using System.Runtime.CompilerServices;
using System.Runtime.InteropServices;

namespace NetFwTypeLib
{
	// Token: 0x02000008 RID: 8
	[CompilerGenerated]
	[Guid("98325047-C671-4174-8D81-DEFCD3F03186")]
	[TypeIdentifier]
	[ComImport]
	public interface INetFwPolicy2
	{
		// Token: 0x0600002D RID: 45
		void _VtblGap1_11();

		// Token: 0x1700000B RID: 11
		// (get) Token: 0x0600002E RID: 46
		[DispId(7)]
		INetFwRules Rules
		{
			[DispId(7)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[return: MarshalAs(UnmanagedType.Interface)]
			get;
		}
	}
}
