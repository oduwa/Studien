//
//  DashboardViewController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 17/05/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "DashboardViewController.h"
#import "AppUtils/AppUtils.h"

@interface DashboardViewController ()

@end

@implementation DashboardViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    _upcomingSession = [NSMutableArray new];
    _pendingSession = [NSMutableArray new];
    
    _upcomingTableView.dataSource = self;
    _pendingTableView.dataSource = self;
    _upcomingTableView.delegate = self;
    _pendingTableView.delegate = self;
    
    if(self.navigationController){
        self.navigationController.navigationBarHidden = YES;
    }
    
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    // Return the number of sections.
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    // Return the number of sections.
    if (tableView == self.upcomingTableView)
    {
        return [_upcomingSession count];
    }
    else{
        return [_pendingSession count];
    }
}

-(CGFloat)tableView:(UITableView *)tableView heightForHeaderInSection:(NSInteger)section
{
    return 60;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    return nil;
}

- (void) tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    
}

-(UIView *)tableView:(UITableView *)tableView viewForHeaderInSection:(NSInteger)section
{
    UIView *view = [[UIView alloc] initWithFrame:CGRectMake(0, 0, tableView.frame.size.width, 60)];
    /* Create custom view to display section header... */
    UILabel *label = [[UILabel alloc] initWithFrame:CGRectMake(10, 5, tableView.frame.size.width-10, 50)];
    label.font = [UIFont systemFontOfSize:19.0 weight:UIFontWeightThin];
    label.textColor = [UIColor whiteColor];
    [view addSubview:label];
    [view setBackgroundColor:[AppUtils colorWithHexString:@"#3c3c3c"]];
    
    if (tableView == self.upcomingTableView)
    {
        label.text = @"Upcoming Sessions (2)";
    }
    else{
        label.text = @"Pending Sessions (2)";
    }
    
    return view;
}



- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
