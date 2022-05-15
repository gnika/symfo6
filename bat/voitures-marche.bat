	setlocal enabledelayedexpansion
	set /A Counter=1
	set /a x=0


	for %%f in (..\parses\parse1\*) do (
		
		if not exist "..\parses\parse1png\\"%%~nf".png" (
		
			if not exist "..\parses\parse1png\\"%%~nf".png" (
			
				
				set /A Counter+=1
				
				if !Counter! LSS 16 (
					set /p val=<%%f
					start firefox.exe "https://www.leboncoin.fr/voitures/"%%~nf".htm"
					
					timeout 15
					php -f "screenshot.php" -- "%%~nf"
					timeout 1
				)
				
				if !Counter! GEQ 16 (
					taskkill /IM firefox.exe /F
					set /A Counter=0
					timeout 5
					
				)
		
				
			
				
		
			)
		
			
			
		)
		
	)

