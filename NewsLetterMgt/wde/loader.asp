<%

	Class Loader
		Private dict
		
		Private Sub Class_Initialize
			Set dict = Server.CreateObject("Scripting.Dictionary")
		End Sub
		
		Private Sub Class_Terminate
			Dim intDict
			If IsObject(intDict) Then
				intDict.RemoveAll
				Set intDict = Nothing
			End If
			If IsObject(dict) Then
				dict.RemoveAll
				Set dict = Nothing
			End If
		End Sub

		Public Property Get Count
			Count = dict.Count
		End Property

		Public Sub Initialize
			Dim binData
				binData = Request.BinaryRead(Request.TotalBytes)
				getData binData
		End Sub
		
		Public Function getFileData(name)
			If dict.Exists(name) Then
				getFileData = dict(name).Item("Value")
				Else
				getFileData = stringToByte("Not Found")
			End If
		End Function
		
		Public Function getValue(name)
			Dim gv
			If dict.Exists(name) Then
				gv = CStr(dict(name).Item("Value"))
				gv = Left(gv,Len(gv)-2)
				getValue = gv
				Else
				getValue = "Not Found"
			End If
		End Function
		
		Public Function saveToFile(name, path)
			If dict.Exists(name) Then
				Dim temp
					temp = dict(name).Item("Value")
				Dim fso
					Set fso = Server.CreateObject("Scripting.FileSystemObject")
				Dim file
					Set file = fso.CreateTextFile(path)
						Dim tPoint
						For tPoint = 1 to LenB(temp)
						    file.Write Chr(AscB(MidB(temp,tPoint,1)))
						Next
						file.Close
					saveToFile = True
				Else
					saveToFile = False
			End If
		End Function
		
		Public Function getFileName(name)
			If dict.Exists(name) Then
				Dim temp, tempPos
					temp = dict(name).Item("FileName")
					tempPos = 1 + InStrRev(temp, "\")
					getFileName = Mid(temp, tempPos)
				Else
				getFileName = "Not Found"
			End If
		End Function
		
		Public Function getFilePath(name)
			If dict.Exists(name) Then
				Dim temp, tempPos
					temp = dict(name).Item("FileName")
					tempPos = InStrRev(temp, "\")
					getFilePath = Mid(temp, 1, tempPos)
				Else
				getFilePath = "Not Found"
			End If
		End Function
		
		Public Function getFilePathComplete(name)
			If dict.Exists(name) Then
				getFilePathComplete = dict(name).Item("FileName")
				Else
				getFilePathComplete = "Not Found"
			End If
		End Function
		
		Public Function getFileSize(name)
			If dict.Exists(name) Then
				getFileSize = LenB(dict(name).Item("Value"))
				Else
				getFileSize = "Not Found"
			End If
		End Function

		Public Function getFileSizeTranslated(name)
			Dim temp
			If dict.Exists(name) Then
				temp = 1 + LenB(dict(name).Item("Value"))
					If Len(temp) <= 3 Then
						getFileSizeTranslated = temp & " bytes"
						ElseIf Len(temp) > 6 Then
						temp = FormatNumber(((temp / 1024) / 1000), 2)
						getFileSizeTranslated = temp & " megabytes"	
						Else
						temp = FormatNumber((temp / 1024), 2)
						getFileSizeTranslated = temp & " kilobytes"
					End If
				Else
				getFileSizeTranslated = "Not Found"
			End If
		End Function
		
		Public Function getContentType(name)
			If dict.Exists(name) Then
				getContentType = dict(name).Item("ContentType")
				Else
				getContentType = "Not Found"
			End If
		End Function

	Private Sub getData(rawData)
		Dim separator 
			separator = MidB(rawData, 1, InstrB(1, rawData, ChrB(13)) - 1)

		Dim lenSeparator
			lenSeparator = LenB(separator)

		Dim currentPos
			currentPos = 1
		Dim inStrByte
			inStrByte = 1
		Dim value, mValue
		Dim tempValue
			tempValue = ""

		While inStrByte > 0
			inStrByte = InStrB(currentPos, rawData, separator)
			mValue = inStrByte - currentPos

			If mValue > 1 Then
				value = MidB(rawData, currentPos, mValue)

				Dim begPos, endPos, midValue, nValue
				Dim intDict
					Set intDict = Server.CreateObject("Scripting.Dictionary")
		
					begPos = 1 + InStrB(1, value, ChrB(34))
					endPos = InStrB(begPos + 1, value, ChrB(34))
					nValue = endPos

				Dim nameN
					nameN = MidB(value, begPos, endPos - begPos)

				Dim nameValue
					If InStrB(1, value, stringToByte("Content-Type")) > 1 Then

						begPos = 1 + InStrB(endPos + 1, value, ChrB(34))
						endPos = InStrB(begPos + 1, value, ChrB(34))
						
						midValue = MidB(value, begPos, endPos - begPos)
							intDict.Add "FileName", trim(byteToString(midValue))
								
						begPos = 14 + InStrB(endPos + 1, value, stringToByte("Content-Type:"))
						endPos = InStrB(begPos, value, ChrB(13))
						
						midValue = MidB(value, begPos, endPos - begPos)
							intDict.Add "ContentType", trim(byteToString(midValue))
						
						begPos = endPos + 4
						endPos = LenB(value)
						
						nameValue = MidB(value, begPos, endPos - begPos)
					Else
						nameValue = trim(byteToString(MidB(value, nValue + 5)))
					End If

					intDict.Add "Value", nameValue
					intDict.Add "Name", nameN

					dict.Add byteToString(nameN), intDict
			End If

			currentPos = lenSeparator + inStrByte
		Wend
	End Sub
	
	End Class

	Private Function stringToByte(toConv)
		Dim tempChar
		Dim i
		 For i = 1 to Len(toConv)
		 	tempChar = Mid(toConv, i, 1)
			stringToByte = stringToByte & chrB(AscB(tempChar))
		 Next
	End Function

	Private Function byteToString(toConv)
		Dim i
		For i = 1 to LenB(toConv)
			byteToString = byteToString & chr(AscB(MidB(toConv,i,1))) 
		Next
	End Function

%>

