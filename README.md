# compressed-string-demo
Repository with a more detailed use case to demonstrate memory differences between using regular PHP arrays, JSON strings, and the compressed-string package.

### Purpose:

After spending a number of weeks working, eventually creating the Compressed String Package (https://github.com/orware/compressed-string), I wanted to come up with a more detailed example to demonstrate more of what I saw when I was doing my development work.

Essentially, I was initially using PHP arrays and then just started noticing the crazy amount of memory usage that resulted in when I was pulling down a large data set.

It was impacted even more by the fact that some of the conversions occurring in the PHP code were sometimes increasing the memory usage further (due to copying the data, rather than using it by reference).

I then experimented with using JSON strings directly, but even in that case I would run into similar issues with the JSON strings getting copied around and causing double the memory usage that they should be (for example when passing it back in a response in the Slim Framework to the PSR-7 Gzip Encoding Negotiator).

I then started looking into avoiding the PHP array and JSON string formats completely and trying to go straight into a Compressed GZIP String. This proved a bit difficult initially because I didn't seem to see anything anywhere that would allow for a GZIP string to be created directly in memory as a stream (initially I used the PHP GZIP functions and that worked, but eventually the string had to get decoded to be embedded in a string containing some metadata which defeated the purpose of compressing things since it increased the memory usage again).

Eventually I found this PHP package (https://github.com/cyberdummy/gzstream) which had most of the pieces that I required, but still limited the functionality I wanted to create so in the compressed-string package I have a forked copy of a portion of the gzstream package along with my extra wrapper on top to make working with the compressed strings a bit easier.

It's not super well-tested yet, but I'd love to get some additional feedback from others that check it out!

### Testing Notes:

You can clone this repository and do a composer install on your end to bring down the need compressed-string package (there's a JSON streaming parser that's currently included as well in the composer file but it's not actually needed.

You can run the tests by opening up any of the test pages in the browser (each of these will currently run the tests 100 times using all records in the shakespeare.db database):
* tests_php_array.php
* tests_json_string.php
* tests_gzencode_json_string_level_1.php
* tests_gzencode_json_string_level_6.php
* tests_compressed_string_level_1.php
* tests_compressed_string_level_6.php

You can tweak the number of iterations in each of the test pages individually.

You can tweak the query on the last line of the includes.php file if you want to change the number of records retrieved (111,396 records total). A commented out example is shown there as well.


### Average Execution Time (in seconds) Data:

| Test Type	| Average of Execution Time (in seconds) (1K Records) |
| --------- | -------------------------------------- |
| php_array	| 0.015140018 |
| json_string	| 0.019370005 |
| compressed_string_level_1	| 0.028969996 |
| compressed_string_level_6	| 0.038779991 |

| Test Type	| Average of Execution Time (in seconds) (100K Records) |
| --------- | -------------------------------------- |
| php_array	| 0.413181319236755 |
| json_string	| 0.991686592102051 |
| gzencode_json_string_level_1	| 1.194389389 |
| gzencode_json_string_level_6	| 1.520912058 |
| compressed_string_level_1	| 1.788661122322080 |
| compressed_string_level_6	| 2.228159985542300 |

### Peak Memory Usage Information (in bytes):

| Test Type	| Peak Memory Usage (Bytes) (1K Records) |
| --------- | -------------------------------------- |
| php_array	| 1,572,864 |
| json_string	| 786,432 |
| compressed_string_level_1	| 1,310,720 |
| compressed_string_level_6	| 1,310,720 |

| Test Type	| Peak Memory Usage (Bytes) (100K Records) |
| --------- | -------------------------------------- |
| php_array	| 118,226,944 |
| json_string	| 17,301,504 |
| gzencode_json_string_level_1	| 34,865,152 |
| gzencode_json_string_level_6	| 34,865,152 |
| compressed_string_level_1	| 4,718,592 |
| compressed_string_level_6	| 4,194,304 |

### Normalized Execution Times:

Normalized on the regular PHP array since this is the fastest.

| Test Type	| Execution Time Factor (1K Records) |
| --------- | --------------------------------------
| php_array	| 1 |
| json_string	| 1.279391117 |
| compressed_string_level_1	| 1.913471641 |
| compressed_string_level_6	| 2.561422945 |

Above you can see that the JSON String conversion adds 28% to the execution time compared to the regular PHP array, whereas the Compressed String options are 2.0 to 2.5 times slower than the regular PHP array.

In real-world time, if you look at the data further above the actual extra time here is fairly minimal (going from 15 ms in the best case with the PHP array to about 40 ms with the slowest Compressed String option).

| Test Type	| Execution Time Factor (100K Records) |
| --------- | --------------------------------------
| php_array	| 1 |
| json_string	| 2.400124463 |
| gzencode_json_string_level_1	| 2.89071488325 |
| gzencode_json_string_level_6	| 3.68097972292 |
| compressed_string_level_1	| 4.328998043 |
| compressed_string_level_6	| 5.392692946 |

When we're looking at a larger number of records, all of the non-PHP array options increase the execution time significantly, but still in the worst case it's only about 5.5 times slower than when you use a PHP array.

In real-world time, this could be a fairly significant difference depending on your particular use case/application, going from 413 ms in the PHP array case to about 2230 ms in the worst case with the Compressed String with Level 6 compression.

### Normalized Peak Memory Usage:

Normalized on the the Compressed String with Level 6 compression since this should typically result in the smallest memory usage.

| Test Type	| Peak Memory Usage Factor (1K Records) |
| --------- | --------------------------------------
| php_array	| 1.2 |
| json_string	| 0.6 |
| compressed_string_level_1	| 1 |
| compressed_string_level_6	| 1 |

When dealing with a small number of records we only see a slight improvement in memory usage when using the Compressed Strings, and in this particular example, actually the JSON string achieves the lowest memory usage.

| Test Type	| Peak Memory Usage Factor (100K Records) |
| --------- | --------------------------------------
| php_array	| 28.1875 |
| json_string	| 4.125 |
| gzencode_json_string_level_1	| 8.3125 |
| gzencode_json_string_level_6	| 8.3125 |
| compressed_string_level_1	| 1.125 |
| compressed_string_level_6	| 1 |

However, when we're dealing with a large number of records, the difference is pretty dramatic with the Compressed String options achieving a close to 30x reduction in memory usage and also use significantly less memory than even the JSON string option.

In real-world terms, this means going from 112.75 MB of memory usage (in the PHP Array case), to 16.5 MB (in the JSON String case), to 4.5 MB and 4 MB in the Compressed String Level 1 and Level 6 cases.

This memory savings could actually be a pretty big memory saver for an application that is primarily generating JSON / compressed JSON output from a database for an API.