//
//  WhiteboardViewController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 21/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "WhiteboardViewController.h"
#import "StrokeGestureRecognizer.h"
#import "AppUtils.h"

@interface WhiteboardViewController ()

@end

@implementation WhiteboardViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    self.navigationController.navigationBar.backgroundColor = [AppUtils colorWithHexString:@"#3C3C3C"];
    [self.navigationController.navigationBar setTranslucent:NO];
    
    self.COLORS = @[
                           [AppUtils colorWithHexString:@"#333333"],
                           [AppUtils colorWithHexString:@"#7059ac"],
                           [AppUtils colorWithHexString:@"#196e76"],
                           [AppUtils colorWithHexString:@"#80a9cc"],
                           [AppUtils colorWithHexString:@"#fafafa"]
                           ];
    self.COLOR_NAMES = @[
                    @"A",
                    @"B",
                    @"C",
                    @"D",
                    @"E"
                    ];

    _currentColor = _COLORS[0];
    
    
    _markerButton.backgroundColor = [AppUtils colorWithHexString:APP_PRIMARY_COLOUR];
    _markerButton.layer.cornerRadius = _markerButton.frame.size.width/2.0;
    _markerButton.layer.masksToBounds = YES;
    
    self.whiteboardView.strokeList = [NSMutableArray array];
    StrokeGestureRecognizer *gestureRecognizer = [[StrokeGestureRecognizer alloc] initWithTarget:self action:@selector(strokeGestureDidChange:)];
    [self.whiteboardView addGestureRecognizer:gestureRecognizer];
    
}

- (void) viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
    
    if(self.navigationController){
        self.navigationController.navigationBarHidden = NO;
    }
}

- (void) viewWillDisappear:(BOOL)animated
{
    [super viewWillDisappear:animated];
    
    if(self.navigationController){
        self.navigationController.navigationBarHidden = YES;
    }
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

# pragma mark - Actions

- (IBAction)didPressPenButton:(id)sender {
    UIAlertController *actionSheet = [UIAlertController alertControllerWithTitle:nil message:@"Select Marker Colour" preferredStyle:UIAlertControllerStyleActionSheet];
    
    for(int i = 0; i < [_COLORS count]; i++){
        [actionSheet addAction:[UIAlertAction actionWithTitle:_COLOR_NAMES[i] style:UIAlertActionStyleDefault handler:^(UIAlertAction *action) {
            _currentColor = _COLORS[i];
        }]];
    }
    [actionSheet addAction:[UIAlertAction actionWithTitle:@"Cancel" style:UIAlertActionStyleCancel handler:^(UIAlertAction *action) {
        
        // Cancel button tappped.
        [actionSheet dismissViewControllerAnimated:YES completion:nil];
    }]];


    // Present action sheet.
    [self presentViewController:actionSheet animated:YES completion:nil];

}

- (IBAction)didPressClearButton:(id)sender {
    _whiteboardView.strokeList = [NSMutableArray array];
    [_whiteboardView setNeedsDisplay];
}

- (IBAction)didPressEraserButton:(id)sender {
    _currentColor = self.whiteboardView.backgroundColor;
    
    _markerButton.backgroundColor = [UIColor clearColor];
    _markerButton.layer.cornerRadius = _markerButton.frame.size.width/2.0;
    _markerButton.layer.masksToBounds = YES;
    _eraserButton.backgroundColor = [AppUtils colorWithHexString:APP_PRIMARY_COLOUR];
    _eraserButton.layer.cornerRadius = _eraserButton.frame.size.width/2.0;
    _eraserButton.layer.masksToBounds = YES;
    _clearButton.backgroundColor = [UIColor clearColor];
    _clearButton.layer.cornerRadius = _clearButton.frame.size.width/2.0;
    _clearButton.layer.masksToBounds = YES;
}

- (void) strokeGestureDidChange:(StrokeGestureRecognizer*)sender
{
    if(sender.state == UIGestureRecognizerStateBegan){
        Stroke *newStroke = [[Stroke alloc] initWithStartPoint:sender.position andColor:_currentColor];
        [_whiteboardView.strokeList addObject:newStroke];
    }
    else{
        [_whiteboardView continueStroke:sender.position];
    }
    
    [_whiteboardView setNeedsDisplay];
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
