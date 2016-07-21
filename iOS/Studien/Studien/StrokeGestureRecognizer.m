//
//  StrokeGestureRecognizer.m
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "StrokeGestureRecognizer.h"
#import "UIKit/UIGestureRecognizerSubclass.h"

@implementation StrokeGestureRecognizer

- (void)touchesBegan:(NSSet<UITouch *> *)touches
           withEvent:(UIEvent *)event
{
    self.position = [WBPoint pointWithCGPoint:[touches.anyObject locationInView:self.view]];
    self.state = UIGestureRecognizerStateBegan;
}

- (void)touchesMoved:(NSSet<UITouch *> *)touches
           withEvent:(UIEvent *)event
{
    self.position = [WBPoint pointWithCGPoint:[touches.anyObject locationInView:self.view]];
    self.state = UIGestureRecognizerStateChanged;
}

- (void)touchesEnded:(NSSet<UITouch *> *)touches
           withEvent:(UIEvent *)event
{
    self.position = [WBPoint pointWithCGPoint:[touches.anyObject locationInView:self.view]];
    self.state = UIGestureRecognizerStateEnded;
}

- (void)touchesCancelled:(NSSet<UITouch *> *)touches
               withEvent:(UIEvent *)event
{
    self.position = [WBPoint pointWithCGPoint:[touches.anyObject locationInView:self.view]];
    self.state = UIGestureRecognizerStateEnded;
}

@end
