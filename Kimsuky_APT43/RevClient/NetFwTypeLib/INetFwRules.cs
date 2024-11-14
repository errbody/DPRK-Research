using System;
using System.Collections;
using System.Runtime.CompilerServices;
using System.Runtime.InteropServices;

namespace NetFwTypeLib
{
	// Token: 0x0200000A RID: 10
	[CompilerGenerated]
	[Guid("9C4C6277-5027-441E-AFAE-CA1F542DA009")]
	[TypeIdentifier]
	[ComImport]
	public interface INetFwRules : IEnumerable
	{
		// Token: 0x06000043 RID: 67
		void _VtblGap1_1();

		// Token: 0x06000044 RID: 68
		[DispId(2)]
		[MethodImpl(MethodImplOptions.InternalCall)]
		void Add([MarshalAs(UnmanagedType.Interface)] [In] INetFwRule rule);

		// Token: 0x06000045 RID: 69
		[DispId(3)]
		[MethodImpl(MethodImplOptions.InternalCall)]
		void Remove([MarshalAs(UnmanagedType.BStr)] [In] string Name);
	}
}
