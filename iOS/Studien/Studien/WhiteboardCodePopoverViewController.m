//
//  WhiteboardCodePopoverViewController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 09/07/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "WhiteboardCodePopoverViewController.h"
#import "MZFormSheetPresentationController.h"
#import "WhiteboardViewController.h"

@interface WhiteboardCodePopoverViewController (){
    BOOL isKeyboardShown;
    float offset;
    CGFloat logoContainerHeight;
}

@end

@implementation WhiteboardCodePopoverViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    /* Listener for field dismissal */
    UITapGestureRecognizer *tapRecognizer = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(didTap)];
    [self.view addGestureRecognizer:tapRecognizer];
}

- (void) viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    
    /* Register for keyboard notifications */
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardWasShown:) name:UIKeyboardWillShowNotification object:nil];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardWasHidden:) name:UIKeyboardWillHideNotification object:nil];
}

- (void) viewWillDisappear:(BOOL)animated
{
    [super viewWillDisappear:animated];
    
    /* Unregister for keyboard notifications */
    [[NSNotificationCenter defaultCenter] removeObserver:self name:UIKeyboardWillShowNotification object:nil];
    [[NSNotificationCenter defaultCenter] removeObserver:self name:UIKeyboardWillHideNotification object:nil];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


#pragma mark - Keyboard Handling

#pragma mark - Keyboard Handling

- (void) keyboardWasShown:(NSNotification *) notification
{
    if(isKeyboardShown){
        return;
    }
    
    isKeyboardShown = YES;
    
    NSDictionary *info = [notification userInfo];
    CGRect keyboardFrame = [info[UIKeyboardFrameEndUserInfoKey] CGRectValue];
    float animationDuration = [info[UIKeyboardAnimationDurationUserInfoKey] floatValue];
    
    CGRect fieldFrame = _idField.frame;
    CGFloat intersectHeight = keyboardFrame.origin.y -(fieldFrame.origin.y + fieldFrame.size.height);
    
    if([UIScreen mainScreen].bounds.size.height <= 480){
        if(intersectHeight > 0) _fieldBottomConstraint.constant -= intersectHeight;
        offset = intersectHeight;
    }
    
    
    [UIView animateWithDuration:animationDuration animations:^{
        [self.view layoutIfNeeded];
    }];
}

- (void) keyboardWasHidden:(NSNotification *) notification
{
    isKeyboardShown = NO;
    
    NSDictionary *info = [notification userInfo];
    float animationDuration = [info[UIKeyboardAnimationDurationUserInfoKey] floatValue];
    
    _fieldBottomConstraint.constant += offset;
    
    
    [UIView animateWithDuration:animationDuration animations:^{
        [self.view layoutIfNeeded];
    } completion:^(BOOL finished) {
        
    }];
}


#pragma mark - Actions

- (IBAction)didPressCancelButton:(id)sender {
    [self dismissViewControllerAnimated:YES completion:nil];
}

- (IBAction)didPressEnterButton:(id)sender {
    WhiteboardViewController *wvc = [self.storyboard instantiateViewControllerWithIdentifier:@"WhiteboardViewController"];
    [self.presentingDashboard.navigationController pushViewController:wvc animated:YES];
    [self dismissViewControllerAnimated:YES completion:nil];
}

- (void) didTap
{
    [self.view endEditing:YES];
}



@end
