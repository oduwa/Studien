//
//  WBView.m
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "WBView.h"

@implementation WBView

- (void) drawStroke:(Stroke *)stroke
{
    // ensure the stroke is provided
    if(!stroke){
        return;
    }
    
    // set up the drawing context
    CGContextRef context = UIGraphicsGetCurrentContext();
    CGContextSetStrokeColorWithColor(context, stroke.color.CGColor);
    CGContextSetLineWidth(context, 20.0);
    CGContextSetLineCap(context, kCGLineCapRound);
    CGContextSetLineJoin(context, kCGLineJoinRound);
    
    // move the line to the start point
    CGContextMoveToPoint(context, [stroke startPoint].x, [stroke startPoint].y);
    
    // add each line in the path
    for (int i = 1; i < [stroke.points count]; i++){
        WBPoint *point = stroke.points[i];
        CGContextAddLineToPoint(context, point.x, point.y);
    }
    
    // stroke the path
    CGContextStrokePath(context);;
}

// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect {
    [super drawRect:rect];
    
    // Drawing code
    // ensure the stroke is provided
    if(!_strokeList){
        return;
    }
    
    for(Stroke *stroke in _strokeList){
        [self drawStroke:stroke];
    }
    
    
}

- (void) continueStroke:(WBPoint *)point
{
    Stroke *currentStroke = [_strokeList lastObject];
    [currentStroke addPoint:point];
}




@end
