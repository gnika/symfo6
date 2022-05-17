	setlocal enabledelayedexpansion
	set /A Counter=1
	set /A Counter2=1
	set /a x=0


	for %%f in (..\parses\parse2\*) do (
		
		if not exist "..\parses\Parse2png\\"%%~nf".png" (
		
			if not exist "..\parses\Parse2png\\"%%~nf".png" (
			
				
				set /A Counter+=1
				
				if !Counter! LSS 15 (
					set /p val=<%%f
					start firefox.exe "https://www.leboncoin.fr/voitures/"%%~nf".htm"
					
					timeout 17
					php -f "screenshotimmo.php" -- "%%~nf"
				)
				
				if !Counter! GEQ 15 (
					taskkill /IM firefox.exe /F
					set /A Counter=0
					set /A Counter2+=1
					timeout 5
					
				)
				
				if !Counter2! GEQ 2 (
					
					set /A Counter2=0
					timeout 70
					
				)
		
				
			
				
		
			)
		
			
			
		)
		
	)

