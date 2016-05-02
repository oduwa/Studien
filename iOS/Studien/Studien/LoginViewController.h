//
//  LoginViewController.h
//  Studien
//
//  Created by Odie Edo-Osagie on 02/05/2016.
//  Copyright © 2016 Odie Edo-Osagie. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface LoginViewController : UIViewController

@property (weak, nonatomic) IBOutlet UIImageView *logoImageView;
@property (weak, nonatomic) IBOutlet UITextField *emailTextField;
@property (weak, nonatomic) IBOutlet UITextField *passwordTextField;
@property (weak, nonatomic) IBOutlet NSLayoutConstraint *textFieldBottomConstraint;


- (IBAction)didPressSignInButton:(id)sender;


@end
