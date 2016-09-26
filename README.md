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

| Test Type	| Execution Time Factor (100K Records) |
| --------- | --------------------------------------
| php_array	| 1 |
| json_string	| 2.400124463 |
| compressed_string_level_1	| 4.328998043 |
| compressed_string_level_6	| 5.392692946 |

### Normalized Peak Memory Usage:

Normalized on the the Compressed String with Level 6 compression since this should typically result in the smallest memory usage.

| Test Type	| Peak Memory Usage Factor (1K Records) |
| --------- | --------------------------------------
| php_array	| 1.2 |
| json_string	| 0.6 |
| compressed_string_level_1	| 1 |
| compressed_string_level_6	| 1 |

| Test Type	| Peak Memory Usage Factor (100K Records) |
| --------- | --------------------------------------
| php_array	| 28.1875 |
| json_string	| 4.125 |
| compressed_string_level_1	| 1.125 |
| compressed_string_level_6	| 1 |