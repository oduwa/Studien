//
//  LoginViewController.m
//  Studien
//
//  Created by Odie Edo-Osagie on 02/05/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import "LoginViewController.h"
#import "DashboardViewController.h"
#import "AppUtils/AppUtils.h"

@interface LoginViewController (){
    BOOL isKeyboardShown;
    float offset;
    
    UIActivityIndicatorView *activityIndicator;
}

@end

@implementation LoginViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    
    _emailTextField.attributedPlaceholder = [[NSAttributedString alloc] initWithString:@"email" attributes:@{NSForegroundColorAttributeName: [UIColor whiteColor]}];
    _passwordTextField.attributedPlaceholder = [[NSAttributedString alloc] initWithString:@"password" attributes:@{NSForegroundColorAttributeName: [UIColor whiteColor]}];
    _passwordTextField.secureTextEntry = YES;
    
    UITapGestureRecognizer *tapRecognizer = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(didTap)];
    [self.view addGestureRecognizer:tapRecognizer];
    
    /* Bottom borders for Text Fields */
    CALayer *usernameBorder = [CALayer layer];
    CGFloat borderWidth = 1;
    usernameBorder.borderColor = [AppUtils colorWithHexString:@"#b44929"].CGColor;
    usernameBorder.frame = CGRectMake(0, _emailTextField.frame.size.height - borderWidth, [UIScreen mainScreen].bounds.size.width-50, _emailTextField.frame.size.height);
    usernameBorder.borderWidth = borderWidth;
    [_emailTextField.layer addSublayer:usernameBorder];
    _emailTextField.layer.masksToBounds = YES;
    
    /*
    CALayer *passwordBorder = [CALayer layer];
    passwordBorder.borderColor = [AppUtils colorWithHexString:@"#b44929"].CGColor;
    passwordBorder.frame = CGRectMake(0, _passwordTextField.frame.size.height - borderWidth, [UIScreen mainScreen].bounds.size.width-40, _passwordTextField.frame.size.height);
    passwordBorder.borderWidth = borderWidth;
    [_passwordTextField.layer addSublayer:passwordBorder];
    _passwordTextField.layer.masksToBounds = YES;
     */
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
    offset = (keyboardHeight - (keyboardHeight/1.5));
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
    DashboardViewController *dvc = [self.storyboard instantiateViewControllerWithIdentifier:@"DashboardViewController"];
    UINavigationController *nvc = [[UINavigationController alloc] initWithRootViewController:dvc];
    [self presentViewController:nvc animated:YES completion:nil];
}

- (IBAction)didEditEmailField:(id)sender {
    if([AppUtils isStringEmpty:[_emailTextField text]] || [AppUtils isStringEmpty:[_passwordTextField text]]){
        [_signInButton setTitleColor:[AppUtils colorWithHexString:@"#4C4C4C"] forState:UIControlStateNormal];
    }
    else{
        [_signInButton setTitleColor:[AppUtils colorWithHexString:@"#2BAAE1"] forState:UIControlStateNormal];
    }
}

- (IBAction)didEditPasswordField:(id)sender {
    if([AppUtils isStringEmpty:[_emailTextField text]] || [AppUtils isStringEmpty:[_passwordTextField text]]){
        [_signInButton setTitleColor:[AppUtils colorWithHexString:@"#4C4C4C"] forState:UIControlStateNormal];
    }
    else{
        [_signInButton setTitleColor:[AppUtils colorWithHexString:@"#2BAAE1"] forState:UIControlStateNormal];
    }
}


@end
