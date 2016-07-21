//
//  DashboardTableViewCell.h
//  Studien
//
//  Created by Odie Edo-Osagie on 05/06/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "SWRevealTableViewCell.h"

@interface DashboardTableViewCell : SWRevealTableViewCell 


@property (weak, nonatomic) IBOutlet UIView *separatorView;
@property (weak, nonatomic) IBOutlet UILabel *dateLabel;
@property (weak, nonatomic) IBOutlet UILabel *timeLabel;
@property (weak, nonatomic) IBOutlet UILabel *topRightLabel;
@property (weak, nonatomic) IBOutlet UILabel *bottomRightLabel;

@end
