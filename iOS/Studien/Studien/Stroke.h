//
//  Stroke.h
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>
#import "WBPoint.h"

@interface Stroke : NSObject

@property (nonatomic, strong) NSMutableArray *points;
@property (nonatomic, strong) UIColor *color;

- (id) initWithStartPoint:(WBPoint *)point andColor:(UIColor *)color;

- (void) addPoint:(WBPoint *)point;
- (WBPoint *) startPoint;

@end
