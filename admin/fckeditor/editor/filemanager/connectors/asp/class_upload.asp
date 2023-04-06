<%
 ' FCKeditor - The text editor for Internet - http://www.fckeditor.net
 ' Copyright (C) 2003-2008 Frederico Caldeira Knabben
 '
 ' == BEGIN LICENSE ==
 '
 ' Licensed under the terms of any of the following licenses at your
 ' choice:
 '
 '  - GNU General Public License Version 2 or later (the "GPL")
 '    http://www.gnu.org/licenses/gpl.html
 '
 '  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 '    http://www.gnu.org/licenses/lgpl.html
 '
 '  - Mozilla Public License Version 1.1 or later (the "MPL")
 '    http://www.mozilla.org/MPL/MPL-1.1.html
 '
 ' == END LICENSE ==
 '
 ' These are the classes used to handle ASP upload without using third
 ' part components (OCX/DLL).
%>
<%
'**********************************************
' File:		NetRube_Upload.asp
' Version:	NetRube Upload Class Version 2.3 Build 20070528
' Author:	NetRube
' Email:	NetRube@126.com
' Date:		05/28/2007
' Comments:	The code for the Upload.
'			This can free usage, but please
'			not to delete this copyright information.
'			If you have a modification version,
'			Please send out a duplicate to me.
'**********************************************
' 文件名:	NetRube_Upload.asp
' 版本:		NetRube Upload Class Version 2.3 Build 20070528
' 作者:		NetRube(网络乡巴佬)
' 电子邮件:	NetRube@126.com
' 日期:		2007年05月28日
' 声明:		文件上传类
'			本上传类可以自由使用，但请保留此版权声明信息
'			如果您对本上传类进行修改增强，
'			请发送一份给俺。
'**********************************************

Class NetRube_Upload

	Public	File, Form
	Private oSourceData
	Private nMaxSize, nErr, sAllowed, sDenied, sHtmlExtensions

	Private Sub Class_Initialize
		nErr		= 0
		nMaxSize	= 1048576

		Set File			= Server.CreateObject("Scripting.Dictionary")
		File.CompareMode	= 1
		Set Form			= Server.CreateObject("Scripting.Dictionary")
		Form.CompareMode	= 1

		Set oSourceData		= Server.CreateObject("ADODB.Stream")
		oSourceData.Type	= 1
		oSourceData.Mode	= 3
		oSourceData.Open
	End Sub

	Private Sub Class_Terminate
		Form.RemoveAll
		Set Form = Nothing
		File.RemoveAll
		Set File = Nothing

		oSourceData.Close
		Set oSourceData = Nothing
	End Sub

	Public Property Get Version
		Version = "NetRube Upload Class Version 2.3 Build 20070528"
	End Property

	Public Property Get ErrNum
		ErrNum	= nErr
	End Property

	Public Property Let MaxSize(nSize)
		nMaxSize	= nSize
	End Property

	Public Property Let Allowed(sExt)
		sAllowed	= sExt
	End Property

	Public Property Let Denied(sExt)
		sDenied	= sExt
	End Property

	Public Property Let HtmlExtensions(sExt)
		sHtmlExtensions	= sExt
	E