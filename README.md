# compressed-string-demo
Repository with a more detailed use case to demonstrate memory differences between using regular PHP arrays, JSON strings, and the compressed-string package.

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
| compressed_string_level_1	| 1.788661122322080 |
| compressed_string_level_6	| 2.228159985542300 |

### Peak Memory Usage Information (in bytes):

| Test Type	| Peak Memory Usage (Bytes) (1K Records) |
| --------- | -------------------------------------- |
| php_array	| 1572864 |
| json_string	| 786432 |
| compressed_string_level_1	| 1310720 |
| compressed_string_level_6	| 1310720 |

| Test Type	| Peak Memory Usage (Bytes) (100K Records) |
| --------- | -------------------------------------- |
| php_array	| 118226944 |
| json_string	| 17301504 |
| compressed_string_level_1	| 4718592 |
| compressed_string_level_6	| 4194304 |

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
| compressed_string_level_1	| 1.125 |
| compressed_string_level_6	| 1 |

However, when we're dealing with a large number of records, the difference is pretty dramatic with the Compressed String options achieving a close to 30x reduction in memory usage and also use significantly less memory than even the JSON string option.

In real-world terms, this means going from 112.75 MB of memory usage (in the PHP Array case), to 16.5 MB (in the JSON String case), to 4.5 MB and 4 MB in the Compressed String Level 1 and Level 6 cases.

This memory savings could actually be a pretty big memory saver for an application that is primarily generating JSON / compressed JSON output from a database for an API.