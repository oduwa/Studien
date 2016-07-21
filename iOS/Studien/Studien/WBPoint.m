//
//  WBPoint.m
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "WBPoint.h"

@implementation WBPoint

- (id) initWithX:(float)x andY:(float)y
{
    self = [super init];
    
    if(self){
        self.x = x;
        self.y = y;
    }
    
    return self;
}

+ (WBPoint *)pointWithX:(float)x andY:(float)y
{
    return [[WBPoint alloc] initWithX:x andY:y];
}

+ (WBPoint *)pointWithCGPoint:(CGPoint)point
{
    return [[WBPoint alloc] initWithX:point.x andY:point.y];
}

@end
