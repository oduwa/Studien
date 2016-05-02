//
//  AppUtils.h
//  Syren
//
//  Created by Odie Edo-Osagie on 31/03/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <AVFoundation/AVFoundation.h>
#import <UIKit/UIKit.h>

#define DEVICE_SIZE [[[[UIApplication sharedApplication] keyWindow] rootViewController].view convertRect:[[UIScreen mainScreen] bounds] fromView:nil].size

#define SOUNDCLOUD_API_KEY @"693f8132aa4a1aa8d1366fdb87e72f3e"


#define APP_PRIMARY_COLOUR @"#ffce54"
#define APP_SECONDARY_COLOUR1 @"#4f5a69"
#define APP_SECONDARY_COLOUR2 @"#533840"
#define APP_SECONDARY_COLOUR3 @"#464f5c"


@interface AppUtils : NSObject



/**
 * Creates a singleton instance of an AppUtils object from which methods and resources can be shraed
 * throughout the application
 *
 * @return AppUtils singleton instance
 */
+ (AppUtils *) sharedUtils;

+(UIImage *) placeholderImage;
+ (void) makeNavBar:(UINavigationBar *)navBar transparent:(BOOL)shouldNavBarTransparent;
+ (void) setText:(NSString *)text andColour:(UIColor *)colour asPlaceholderForTextField:(UITextField *)textField;
+ (BOOL)isIOS7OrHigher;
+ (BOOL)isIOS8OrHigher;
+ (CGSize) screenResolutionSize;
+ (BOOL) isIPhone5;
+ (BOOL) isIPhone6;
+ (BOOL) isIPhone6Plus;
+ (BOOL)isConnectedToInternet;
+ (void) printFontNames;
+ (CGFloat) mimimumSizeForNavTitleText:(NSString *)text WithFont:(UIFont *)font;
+ (UIColor *) colorWithHexString:(NSString *)hexString;
+ (UIColor *) iOS7BlueColour;
+ (UIImage *) imageWithColor:(UIColor *)color;
+ (UIImage *) blurredSnapshotOfWindow;
+ (NSData *)removeHtmlEntities:(NSData *)data;
+ (BOOL) NSStringIsValidEmail:(NSString *)checkString;
+ (NSString *)convertSecondsToHoursMinutesAndSeconds:(int)seconds;
+ (NSString *)arrangeStringsAlphabetically:(NSArray *)strings;
+ (BOOL)isStringEmpty:(NSString *)string;
+ (BOOL) isPushEnabled;


@end
