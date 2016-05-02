//
//  NSArray+Helpers.m
//  Jive
//
//  Created by Odie Edo-Osagie on 09/08/2014.
//  Copyright (c) 2014 Odie Edo-Osagie. All rights reserved.
//

#import "NSArray+Helpers.h"

@implementation NSArray (Helpers)

- (NSArray *) shuffledArray
{
	// create temporary mutable array
	NSMutableArray *tmpArray = [NSMutableArray arrayWithCapacity:[self count]];
    
	for (id anObject in self)
	{
		NSUInteger randomPos = arc4random()%([tmpArray count]+1);
		[tmpArray insertObject:anObject atIndex:randomPos];
	}
    
	return [NSArray arrayWithArray:tmpArray];
}

@end
