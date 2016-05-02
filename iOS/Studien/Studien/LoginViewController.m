//
//  LoginViewController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 02/05/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "LoginViewController.h"

@interface LoginViewController (){
    BOOL isKeyboardShown;
    float offset;
    
    UIActivityIndicatorView *activityIndicator;
}

@end

@implementation LoginViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    
    _passwordTextField.secureTextEntry = YES;
    
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

- (void) keyboardWasShown:(NSNotification *) notification
{
    if(isKeyboardShown){
        return;
    }
    
    isKeyboardShown = YES;
    
    NSDictionary *info = [notification userInfo];
    CGRect keyboardFrame = [info[UIKeyboardFrameEndUserInfoKey] CGRectValue];
    float animationDuration = [info[UIKeyboardAnimationDurationUserInfoKey] floatValue];
    
    float keyboardHeight = keyboardFrame.size.height;
    offset = (keyboardHeight - 36);
    _textFieldBottomConstraint.constant += offset ;
    _logoImageView.hidden = YES;
    
    /* Check if top field will intersect with logo image */
    float screenHeight = [[UIScreen mainScreen] bounds].size.height;
    if(screenHeight <= 568){
        _logoImageView.hidden = YES;
    }
    
    [UIView animateWithDuration:animationDuration animations:^{
        [self.view layoutIfNeeded];
    }];
}

- (void) keyboardWasHidden:(NSNotification *) notification
{
    isKeyboardShown = NO;
    
    NSDictionary *info = [notification userInfo];
    //CGRect keyboardFrame = [info[UIKeyboardFrameEndUserInfoKey] CGRectValue];
    float animationDuration = [info[UIKeyboardAnimationDurationUserInfoKey] floatValue];
    
    _textFieldBottomConstraint.constant -= offset;
    _logoImageView.hidden = NO;
    
    
    [UIView animateWithDuration:animationDuration animations:^{
        [self.view layoutIfNeeded];
    } completion:^(BOOL finished) {
        _logoImageView.hidden = NO;
    }];
}

# pragma mark - Callbacks

- (void) didTap
{
    [self.view endEditing:YES];
}

- (IBAction)didPressSignInButton:(id)sender {
}
@end
