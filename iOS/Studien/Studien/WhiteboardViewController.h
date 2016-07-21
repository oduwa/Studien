//
//  WhiteboardViewController.h
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "WBView.h"

@interface WhiteboardViewController : UIViewController

@property (strong, nonatomic) IBOutlet WBView *whiteboardView;
@property (weak, nonatomic) IBOutlet UIButton *markerButton;
@property (weak, nonatomic) IBOutlet UIButton *clearButton;
@property (weak, nonatomic) IBOutlet UIButton *eraserButton;


@property (nonatomic, strong) UIColor *currentColor;

@property (nonatomic, strong) NSArray<UIColor*> *COLORS;
@property (nonatomic, strong) NSArray<NSString*> *COLOR_NAMES;
@property (nonatomic, strong)  UIColor *strokeColor;


@end
