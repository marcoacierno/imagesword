4 pictures 1 word
Created inspired by the game for android with a little 'of functions in the least.

How to create a layer:

All levels must be present in the file tests.json
Levels should be progressive as:

1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28

A level will be missing indeso as the end of the game

Basic structure:
"1":
{
"img_1": "url"
"img_2": "url"
"img_3": "url"
"img_4": "url"
"letters", "CDIEAGCOM"
"word": "Hello"
}

img_1, img_2, img_3, img_4: the images that will be shown to the user
letters: the letters that need to be created on the user's screen
word: The word that the user must guess

"1": {

Indicates the corresponding level.

Note: The file tests.json can be opened by a user, and then can see the corresponding answer to his level, my advice is, or modify the script in order to make him read an array or lock the file (for example)

When the word is written to a request is sent to controllo.php to check whether correct or not.
if the wrong word will vibrate to 500 ms and turn red.
if right will reload the page and will be loaded the next level.

clicking on a box the letter will be deleted.

Created mostly out of boredom, but it can be a nice idea for someone.