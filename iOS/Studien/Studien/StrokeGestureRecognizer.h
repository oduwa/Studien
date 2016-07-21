//
//  StrokeGestureRecognizer.h
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Stroke.h"

@interface StrokeGestureRecognizer : UIGestureRecognizer

@property (nonatomic, strong) WBPoint *position;

@end
