//
//  DashboardViewController.h
//  Studien
//
//  Created by Odie Edo-Osagie on 17/05/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface DashboardViewController : UIViewController <UITableViewDataSource, UITableViewDelegate>

@property (nonatomic, strong) NSMutableArray *upcomingSession;
@property (nonatomic, strong) NSMutableArray *pendingSession;

@property (weak, nonatomic) IBOutlet UITableView *upcomingTableView;
@property (weak, nonatomic) IBOutlet UITableView *pendingTableView;

@end
