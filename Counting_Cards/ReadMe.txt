Counting Cards

PHP
	Get pictures of all cards
	Name the pictures after their point value
	Based on level count the amount of shoes to use
	Create an array of pictures (Single Shoe)
	Randomly select a card count
	Randomly select a picture and assign to a new array
	Pop the random picture from the old array
	Add all the pictures together to get the answer
	Cycle through each of the pictures in the new array at a specific speed
	Setup a question and answer pool, as distractions from the count.
	
	
	Database (CardCoutning)
		tblDarknetCodes
			pk
			Difficulty
			DarknetCode
			DateStamp
			
		tblSalt
			pk
			Salt
			DateStamp
		tblQA
			pk
			Difficulty
			Question
			Answer
			DateStamp
