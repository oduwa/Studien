//
//  WBView.h
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Stroke.h"

@interface WBView : UIView

@property (nonatomic, strong) Stroke *stroke;
@property (nonatomic, strong) NSMutableArray<Stroke*> *strokeList;

- (void) continueStroke:(WBPoint *)point;

@end
