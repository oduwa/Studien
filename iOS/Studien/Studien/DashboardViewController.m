//
//  DashboardViewController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 17/05/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "DashboardViewController.h"
#import "DashboardTableViewCell.h"
#import "AppUtils/AppUtils.h"

@interface DashboardViewController ()

@end

@implementation DashboardViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    if(self.navigationController){
        self.navigationController.navigationBarHidden = YES;
    }
    
    _upcomingSession = [NSMutableArray new];
    _pendingSession = [NSMutableArray new];
    
    _upcomingTableView.dataSource = self;
    _pendingTableView.dataSource = self;
    _upcomingTableView.delegate = self;
    _pendingTableView.delegate = self;
    _upcomingTableView.separatorStyle = UITableViewCellSeparatorStyleNone;
    _pendingTableView.separatorStyle = UITableViewCellSeparatorStyleNone;
    _upcomingTableView.backgroundColor = [AppUtils colorWithHexString:@"#3c3c3c"];
    _pendingTableView.backgroundColor = [AppUtils colorWithHexString:@"#3c3c3c"];
    
    [_upcomingTableView registerNib:[UINib nibWithNibName:@"DashboardTableViewCell" bundle:nil] forCellReuseIdentifier:@"upcomingCell"];
    [_pendingTableView registerNib:[UINib nibWithNibName:@"DashboardTableViewCell" bundle:nil] forCellReuseIdentifier:@"upcomingCell"];
    
    _upcomingSession = (NSMutableArray*) @[@3, @2, @1];
    _pendingSession = (NSMutableArray*) @[@3, @2, @1];
    
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
    if(tableView == _upcomingTableView){
        DashboardTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"upcomingCell"];
        cell.dataSource = self;
        cell.dateLabel.text = @"Wed 25/05";
        cell.timeLabel.text = @"10:10 am (2hr)";
        cell.topRightLabel.text = @"Student: Nick";
        cell.bottomRightLabel.text = @"Subject: English Language";
        cell.separatorView.backgroundColor = [AppUtils colorWithHexString:@"#c4685d"];
        if(indexPath.row%2 == 0){
            cell.backgroundColor = [AppUtils colorWithHexString:@"#333333"];
        }
        else{
            cell.backgroundColor = [AppUtils colorWithHexString:@"#4f4f4f"];
        }
        return cell;
    }
    else{
        DashboardTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"upcomingCell"];
        cell.dataSource = self;
        cell.dateLabel.text = @"Wed 25/05";
        cell.timeLabel.text = @"10:10 am (2hr)";
        cell.topRightLabel.text = @"Student: Nick";
        cell.bottomRightLabel.text = @"Subject: English Language";
        cell.separatorView.backgroundColor = [AppUtils colorWithHexString:@"#d8bf58"];
        if(indexPath.row%2 == 0){
            cell.backgroundColor = [AppUtils colorWithHexString:@"#333333"];
        }
        else{
            cell.backgroundColor = [AppUtils colorWithHexString:@"#4f4f4f"];
        }
        return cell;
    }
    
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

# pragma mark - SWRevealt Datasource

- (NSArray*)rightButtonItemsInRevealTableViewCell:(SWRevealTableViewCell *)revealTableViewCell
{
    SWCellButtonItem *item1 = [SWCellButtonItem itemWithTitle:@"decline" handler:nil];
    item1.backgroundColor = [UIColor whiteColor];
    item1.tintColor = [UIColor blackColor];
    item1.width = 75;
    
    SWCellButtonItem *item2 = [SWCellButtonItem itemWithTitle:@"accept" handler:nil];
    item2.backgroundColor = [UIColor whiteColor];
    item2.tintColor = [UIColor blackColor];
    item2.width = 75;
    
    return @[item1, item2];
}


- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
