//
//  Stroke.m
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "Stroke.h"

@implementation Stroke

- (id) initWithStartPoint:(WBPoint *)point andColor:(UIColor *)color
{
    self = [super init];
    
    if(self){
        _points = [NSMutableArray arrayWithObject:point];
        _color = color;
    }
    
    return self;
}

- (void) addPoint:(WBPoint *)point
{
    [_points addObject:point];
}

- (WBPoint *) startPoint
{
    return _points[0];
}

@end
