//
//  WhiteboardCodePopoverViewController.h
//  Studien
//
//  Created by Odie Edo-Osagie on 09/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "DashboardViewController.h"

@interface WhiteboardCodePopoverViewController : UIViewController

@property (strong, nonatomic) DashboardViewController *presentingDashboard;
@property (weak, nonatomic) IBOutlet UILabel *titleLabel;
@property (weak, nonatomic) IBOutlet UITextField *idField;
@property (weak, nonatomic) IBOutlet NSLayoutConstraint *fieldBottomConstraint;

@end
