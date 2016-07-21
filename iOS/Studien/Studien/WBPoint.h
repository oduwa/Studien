//
//  WBPoint.h
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "UIKit/UIKit.h"

@interface WBPoint : NSObject

@property (nonatomic, assign) float x;
@property (nonatomic, assign) float y;

- (id) initWithX:(float)x andY:(float)y;
+ (WBPoint *)pointWithX:(float)x andY:(float)y;
+ (WBPoint *)pointWithCGPoint:(CGPoint)point;

@end
