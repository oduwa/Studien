//
//  CustomTabBarController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 09/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "CustomTabBarController.h"
#import "AppUtils.h"

@interface CustomTabBarController ()

@end

@implementation CustomTabBarController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    // Style
    self.tabBar.barTintColor = [UIColor blackColor];
    
    // Add blue line to top
    CGRect frame = CGRectMake(0.0, 0.0, self.view.bounds.size.width, 2);
    UIView *v = [[UIView alloc] initWithFrame:frame];
    [v setBackgroundColor:[AppUtils colorWithHexString:@"#2baae1"]];
    [self.tabBar addSubview:v];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void) setSelectedIndex:(NSUInteger)selectedIndex
{
    if(selectedIndex == 1){
        NSLog(@"XXX");
    }
    else{
        [super setSelectedIndex:selectedIndex];
    }
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
