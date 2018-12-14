# Testing protocol

## Server
 - wrong ip `[passed]`
 - wrong port `[passed]`
 - no data `[passed]`
 - missing "gameId" `[passed]`
 - missing "key" `[passed]`
 - missing "value"  `[passed]`
 - invalid "gameId" (0) `[passed]`
 - invalid "gameId" (257)
 - "key" to short (0 chars) `[passed]`
 - "key" to long (257 chars) `[passed]`
 - measureType does not exist `[passed]`
 - measureType does exist `[passed]`
 - positive value `[passed]`
 - negative value
 - value = 0 `[passed]`
 
