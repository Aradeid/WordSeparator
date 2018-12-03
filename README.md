# WordSeparator
"Homework" mini-project for the Findologic aptitude test

HOW TO USE:
Open the index.php file on a local server. 
Insert your composite word.
Press the button.
Get the result.

Description:
A simple separator for composite words. Intended for German, but can work with any language as long as a sufficient dictionary is provided.
Sadly has to re-sort even an already sorted dictionary, since an alphabetical order is different from an encoding order.
I initially intended to create a separate file for every word of the alphabet, to reduce memory usage, but since the sample dictionary was so small, I decided to stick with a single array.
A binary search method is used to efficiently cross the array.
During the development it was decided to split the main array into multiple sub-arrays, one for each letter count.
As of writing of this file, the biggest problem with the project is the lack of words in the dictionary. I had to add new words for almost every test.
The input is analyzed from left to write. If a word cannot be found, the process stops, even if other words exist beyond the "resultless" point.

Known Issues:
Error #1 - Non-ASCII characters take 2 positions instead of 1. Does not affect output, but increases amount of redundant comparisons.
Error #2 - All standard string transformation functions don't work as intended on non-ASCII characters, and therefore were not used.
