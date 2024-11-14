using System;
using System.Runtime.CompilerServices;
using System.Runtime.InteropServices;

namespace NetFwTypeLib
{
	// Token: 0x02000009 RID: 9
	[CompilerGenerated]
	[Guid("AF230D27-BABA-4E42-ACED-F524F22CFCE2")]
	[TypeIdentifier]
	[ComImport]
	public interface INetFwRule
	{
		// Token: 0x1700000C RID: 12
		// (get) Token: 0x0600002F RID: 47
		// (set) Token: 0x06000030 RID: 48
		[DispId(1)]
		string Name
		{
			[DispId(1)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[return: MarshalAs(UnmanagedType.BStr)]
			get;
			[DispId(1)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: MarshalAs(UnmanagedType.BStr)]
			[param: In]
			set;
		}

		// Token: 0x1700000D RID: 13
		// (get) Token: 0x06000031 RID: 49
		// (set) Token: 0x06000032 RID: 50
		[DispId(2)]
		string Description
		{
			[DispId(2)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[return: MarshalAs(UnmanagedType.BStr)]
			get;
			[DispId(2)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: MarshalAs(UnmanagedType.BStr)]
			[param: In]
			set;
		}

		// Token: 0x06000033 RID: 51
		void _VtblGap1_4();

		// Token: 0x1700000E RID: 14
		// (get) Token: 0x06000034 RID: 52
		// (set) Token: 0x06000035 RID: 53
		[DispId(5)]
		int Protocol
		{
			[DispId(5)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			get;
			[DispId(5)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: In]
			set;
		}

		// Token: 0x1700000F RID: 15
		// (get) Token: 0x06000036 RID: 54
		// (set) Token: 0x06000037 RID: 55
		[DispId(6)]
		string LocalPorts
		{
			[DispId(6)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[return: MarshalAs(UnmanagedType.BStr)]
			get;
			[DispId(6)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: MarshalAs(UnmanagedType.BStr)]
			[param: In]
			set;
		}

		// Token: 0x06000038 RID: 56
		void _VtblGap2_8();

		// Token: 0x17000010 RID: 16
		// (get) Token: 0x06000039 RID: 57
		// (set) Token: 0x0600003A RID: 58
		[DispId(11)]
		NET_FW_RULE_DIRECTION_ Direction
		{
			[DispId(11)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			get;
			[DispId(11)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: In]
			set;
		}

		// Token: 0x0600003B RID: 59
		void _VtblGap3_4();

		// Token: 0x17000011 RID: 17
		// (get) Token: 0x0600003C RID: 60
		// (set) Token: 0x0600003D RID: 61
		[DispId(14)]
		bool Enabled
		{
			[DispId(14)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			get;
			[DispId(14)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: In]
			set;
		}

		// Token: 0x17000012 RID: 18
		// (get) Token: 0x0600003E RID: 62
		// (set) Token: 0x0600003F RID: 63
		[DispId(15)]
		string Grouping
		{
			[DispId(15)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[return: MarshalAs(UnmanagedType.BStr)]
			get;
			[DispId(15)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: MarshalAs(UnmanagedType.BStr)]
			[param: In]
			set;
		}

		// Token: 0x06000040 RID: 64
		void _VtblGap4_4();

		// Token: 0x17000013 RID: 19
		// (get) Token: 0x06000041 RID: 65
		// (set) Token: 0x06000042 RID: 66
		[DispId(18)]
		NET_FW_ACTION_ Action
		{
			[DispId(18)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			get;
			[DispId(18)]
			[MethodImpl(MethodImplOptions.InternalCall)]
			[param: In]
			set;
		}
	}
}
