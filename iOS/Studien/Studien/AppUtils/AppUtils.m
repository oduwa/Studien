//
//  AppUtils.m
//  Syren
//
//  Created by Odie Edo-Osagie on 31/03/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

#import "AppUtils.h"
#import "UIImage+ImageEffects.h"
#import "Reachability.h"
#import "UIView+BlurEffect.h"

static AppUtils *globalInstance = nil;



@implementation AppUtils



- (id) init
{
    self = [super init];
    
    if(self){
            }
    
    return self;
}

/**
 *
 *  sharedUtils singleton object
 *
 */
+ (AppUtils *) sharedUtils
{
    @synchronized(self)
    {
        if (!globalInstance)
            globalInstance = [[self alloc] init];
        
        return globalInstance;
    }
    
    return globalInstance;
}

+ (UIImage *) placeholderImage
{
    return [UIImage imageNamed:@"placeholder.jpg"];
}

+ (void) makeNavBar:(UINavigationBar *)navBar transparent:(BOOL)shouldNavBarTransparent
{
    if(shouldNavBarTransparent){
        [navBar setBackgroundImage:[[UIImage alloc] init] forBarMetrics:UIBarMetricsDefault];
        navBar.shadowImage = [[UIImage alloc] init];
        navBar.translucent = YES;
    }
    else{
        [navBar setBackgroundImage:nil forBarMetrics:UIBarMetricsDefault];
        navBar.shadowImage = nil;
        navBar.translucent = YES;
    }
}

+ (void) setText:(NSString *)text andColour:(UIColor *)colour asPlaceholderForTextField:(UITextField *)textField
{
    NSAttributedString *usernamePlaceolder = [[NSAttributedString alloc] initWithString:text attributes:@{ NSForegroundColorAttributeName : colour }];
    textField.attributedPlaceholder = usernamePlaceolder;
}

+ (BOOL)isIOS7OrHigher
{
    float versionNumber = floor(NSFoundationVersionNumber);
    return versionNumber > NSFoundationVersionNumber_iOS_6_1;
}

+ (BOOL)isIOS8OrHigher
{
    float versionNumber = floor(NSFoundationVersionNumber);
    return versionNumber > NSFoundationVersionNumber_iOS_7_1;
}

+ (CGSize) screenResolutionSize
{
    CGRect screenBounds = [[UIScreen mainScreen] bounds];
    CGFloat screenScale = [[UIScreen mainScreen] scale];
    CGSize screenSize = CGSizeMake(screenBounds.size.width * screenScale, screenBounds.size.height * screenScale);
    
    return screenSize;
}

+ (BOOL)isIPhone5
{
    return ( fabs( ( double )[ [ UIScreen mainScreen ] bounds ].size.height - ( double )568 ) < DBL_EPSILON );
}

+ (BOOL)isIPhone6
{
    return ( fabs( ( double )[ [ UIScreen mainScreen ] bounds ].size.height - ( double )667 ) < DBL_EPSILON );
}

+ (BOOL)isIPhone6Plus
{
    return ( fabs( ( double )[ [ UIScreen mainScreen ] bounds ].size.height - ( double )736 ) < DBL_EPSILON );
}


+ (BOOL)isConnectedToInternet
{
    Reachability *reachTest = [Reachability reachabilityForInternetConnection];
    NetworkStatus internetStatus = [reachTest  currentReachabilityStatus];
    
    if ((internetStatus != ReachableViaWiFi) && (internetStatus != ReachableViaWWAN)){
        return NO;
    }
    else{
        return YES;
    }
}


+ (void) printFontNames
{
    for (NSString* family in [UIFont familyNames])
    {
        NSLog(@"FONT %@", family);
        for (NSString* name in [UIFont fontNamesForFamilyName: family])
        {
            NSLog(@"  %@", name);
        }
    }
}

+ (BOOL) isPushEnabled
{
    if ([[UIApplication sharedApplication] respondsToSelector:@selector(isRegisteredForRemoteNotifications)])
    {
        return [[UIApplication sharedApplication] isRegisteredForRemoteNotifications];
    }
    else
    {
        UIRemoteNotificationType types = [[UIApplication sharedApplication] enabledRemoteNotificationTypes];
        return (types != UIRemoteNotificationTypeNone);
    }
}


+ (CGFloat) mimimumSizeForNavTitleText:(NSString *)text WithFont:(UIFont *)font
{
    //CGSize requestedTitleSize = [text sizeWithFont:font];
    CGSize requestedTitleSize = [text sizeWithAttributes:@{NSFontAttributeName : font}];
    CGFloat titleWidth = MIN(DEVICE_SIZE.width, requestedTitleSize.width);
    
    return titleWidth;
}

+ (UIColor *) colorWithHexString: (NSString *) hexString
{
    NSString *colorString = [[hexString stringByReplacingOccurrencesOfString: @"#" withString: @""] uppercaseString];
    CGFloat alpha, red, blue, green;
    
    if([hexString isEqualToString:@"nil"]){
        colorString = @"";
    }
    
    switch ([colorString length]) {
        case 3: // #RGB
            alpha = 1.0f;
            red   = [self colorComponentFrom: colorString start: 0 length: 1];
            green = [self colorComponentFrom: colorString start: 1 length: 1];
            blue  = [self colorComponentFrom: colorString start: 2 length: 1];
            break;
        case 4: // #ARGB
            alpha = [self colorComponentFrom: colorString start: 0 length: 1];
            red   = [self colorComponentFrom: colorString start: 1 length: 1];
            green = [self colorComponentFrom: colorString start: 2 length: 1];
            blue  = [self colorComponentFrom: colorString start: 3 length: 1];
            break;
        case 6: // #RRGGBB
            alpha = 1.0f;
            red   = [self colorComponentFrom: colorString start: 0 length: 2];
            green = [self colorComponentFrom: colorString start: 2 length: 2];
            blue  = [self colorComponentFrom: colorString start: 4 length: 2];
            break;
        case 8: // #AARRGGBB
            alpha = [self colorComponentFrom: colorString start: 0 length: 2];
            red   = [self colorComponentFrom: colorString start: 2 length: 2];
            green = [self colorComponentFrom: colorString start: 4 length: 2];
            blue  = [self colorComponentFrom: colorString start: 6 length: 2];
            break;
        case 0: // nil
            return [UIColor whiteColor];
            break;
        default:
            [NSException raise:@"Invalid color value" format: @"Color value %@ is invalid.  It should be a hex value of the form #RBG, #ARGB, #RRGGBB, or #AARRGGBB", hexString];
            break;
    }
    return [UIColor colorWithRed: red green: green blue: blue alpha: alpha];
}

+ (CGFloat) colorComponentFrom: (NSString *) string start: (NSUInteger) start length: (NSUInteger) length {
    NSString *substring = [string substringWithRange: NSMakeRange(start, length)];
    NSString *fullHex = length == 2 ? substring : [NSString stringWithFormat: @"%@%@", substring, substring];
    unsigned hexComponent;
    [[NSScanner scannerWithString: fullHex] scanHexInt: &hexComponent];
    return hexComponent / 255.0;
}

+ (UIColor *)iOS7BlueColour
{
    return [UIColor colorWithRed:0.0 green:122.0/255.0 blue:1.0 alpha:1.0];
}

+ (BOOL)isStringEmpty:(NSString *)string {
    if([string length] == 0) { //string is empty or nil
        return YES;
    }
    
    if(![[string stringByTrimmingCharactersInSet:[NSCharacterSet whitespaceAndNewlineCharacterSet]] length]) {
        //string is all whitespace
        return YES;
    }
    
    return NO;
}

+ (UIImage *)imageWithColor:(UIColor *)color
{
    CGRect rect = CGRectMake(0.0f, 0.0f, 1.0f, 1.0f);
    UIGraphicsBeginImageContext(rect.size);
    CGContextRef context = UIGraphicsGetCurrentContext();
    
    CGContextSetFillColorWithColor(context, [color CGColor]);
    CGContextFillRect(context, rect);
    
    UIImage *image = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return image;
}


+ (NSData *)removeHtmlEntities:(NSData *)data {
    
    NSString *htmlCode = [[NSString alloc] initWithData:data encoding:NSISOLatin1StringEncoding];
    NSMutableString *temp = [NSMutableString stringWithString:htmlCode];
    
    NSError *error;
    NSRegularExpression *regex = [NSRegularExpression regularExpressionWithPattern:@"&.{0,}?;" options:NSRegularExpressionCaseInsensitive error:&error];
    NSString *newString = [regex stringByReplacingMatchesInString:temp options:0 range:NSMakeRange(0, [temp length]) withTemplate:@" "];
    
    NSData *finalData = [newString dataUsingEncoding:NSISOLatin1StringEncoding];
    return finalData;
}

+ (BOOL) NSStringIsValidEmail:(NSString *)checkString
{
    // Discussion http://blog.logichigh.com/2010/09/02/validating-an-e-mail-address/
    BOOL stricterFilter = NO;
    NSString *stricterFilterString = @"^[A-Z0-9a-z\\._%+-]+@([A-Za-z0-9-]+\\.)+[A-Za-z]{2,4}$";
    NSString *laxString = @"^.+@([A-Za-z0-9-]+\\.)+[A-Za-z]{2}[A-Za-z]*$";
    NSString *emailRegex = stricterFilter ? stricterFilterString : laxString;
    NSPredicate *emailTest = [NSPredicate predicateWithFormat:@"SELF MATCHES %@", emailRegex];
    return [emailTest evaluateWithObject:checkString];
}

+ (NSString *)convertSecondsToHoursMinutesAndSeconds:(int)seconds
{
    NSUInteger h = seconds / 3600;
    NSUInteger m = (seconds / 60) % 60;
    NSUInteger s = seconds % 60;
    
    NSString *formattedTime = [NSString stringWithFormat:@"%02lu:%02lu:%02lu", (unsigned long)h, (unsigned long)m, (unsigned long)s];
    return formattedTime;
}

+ (NSString *)arrangeStringsAlphabetically:(NSArray *)strings
{
    NSString *result = @"";
    NSArray *sortedStrings = [strings sortedArrayUsingSelector:@selector(caseInsensitiveCompare:)];
    
    for(NSString *string in sortedStrings){
        if([result isEqualToString:@""]){
            result = [result stringByAppendingString:string];
        }
        else{
            result = [result stringByAppendingString:[NSString stringWithFormat:@" %@", string]];
        }
    }
    
    return result;
}


+ (UIImage *) blurredSnapshotOfWindow
{
    CALayer *layer = [[UIApplication sharedApplication] keyWindow].layer;
    CGFloat scale = [UIScreen mainScreen].scale;
    UIGraphicsBeginImageContextWithOptions(layer.frame.size, NO, scale);
    
    [layer renderInContext:UIGraphicsGetCurrentContext()];
    UIImage *screenshot = UIGraphicsGetImageFromCurrentImageContext();
    
    UIImage *blurredSnapshotImage = [screenshot applyDarkEffect];
    // UIImage *blurredSnapshotImage = [snapshotImage applyExtraLightEffect];
    
    [blurredSnapshotImage applyTintEffectWithColor:[UIColor purpleColor]];
    
    // Be nice and clean your mess up
    UIGraphicsEndImageContext();
    
    return blurredSnapshotImage;
}




@end
