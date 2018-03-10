<?php
require('fpdf.php');

class PDF extends FPDF
{
  function Header()
  {
    $this->Image('logo.png',12,5,50);
    $this->SetFont('Arial','B',45);
    $this->SetXY(60,20);
    $this->Cell(0,0,'Affordable Realty',0,1,'C');
    $this->SetFont('Times','B',15);
    $this->SetXY(60,30);
    $this->Cell(0,0,'(AKA) Affordable Arlington DFW Metro Realty',0,1,'C');
    $this->SetXY(60,37);
    $this->Cell(0,0,'Arlington, Texas',0,1,'C');
    $this->SetFillColor(0,0,0);
    $this->Rect(10, 42, 190, 1, 'F');
    $this->Ln(10);
  }

  function Footer()
  {
    $this->SetFillColor(0,0,0);
    $this->Rect(10, 280, 190, 1, 'F');
    $this->SetY(-15);
    $this->SetFont('Arial','I',10);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    $this->SetY(-15);
    $this->SetFont('Arial','BI',14);
    $this->Cell(0, 10, 'Phone: 817-468-1313', 0,0,'L');
    $this->Cell(0, 10, 'eugene.havran@gmail.com', 0,0,'R');
  }
}

if (array_key_exists('city', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);

  $city = $_GET['city'];
  $pdf->SetTitle($city .' Housing Listings');

  switch ($city) {
    case 'Arlington and Mid-Cities':
      $p1 = 'Following is the City of Arlington, following below Arlington, is the city of Grand Prairie and following below G.P. is the city of Mansfield';
    break;
    default:
      $p1 = $city;
    break;
  }
  $pdf->MultiCell(0, 5, $p1, 0, 'J');

  $p2 = date("m/d/Y") . ' AA Affordable Realty (AAA Affordable Arlington DFW Metro Realty),' . PHP_EOL . '(AHUD/VA approved authorized over 40 years)';
  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, $p2, 0, 'J');

  $p3 = 'Eugene Havran, Owner-Broker has earned from the National Board of Realtors Associaton for exceeding over 42 continuous years for all phases of Real Estate, the status: "REALTOR EMERITUS".';
  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, $p3, 0, 'J');

  $p4 = 'HUD/VA approved 27 years , authorized sales & purchases over 410 years & state licensed.';
  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, $p4, 0, 'J');

  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 10, 'CONTRACT OFFERS ON THIS LIST DUE EACH DAY BEFORE 6:00 P.M.', 0, 'J');

  $pdf->SetY($pdf->GetY() + 5);
  $pdf->SetFont('Times','BU',12);
  $pdf->MultiCell(0, 5, $city . ' addresses');
  $pdf->SetFont('Arial','BU',12);
  $pdf->MultiCell(0, 5, 'ZIP          ADDRESS          MINIMUM PRICE          DESCRIP          YB          ASQF          MAPSCO', 0, 'J');

  $pdf->SetFont('Arial','',12);
  $handle = fopen("../data/pages/listings.txt", "r");
  if ($handle) {
    $readingCityData = false;
    while (($line = fgets($handle)) !== false) {
      if (trim($line) === trim($city)) {
        $readingCityData = true;
      }
      if ($readingCityData && (trim($line) !== '=====')) {
        if (trim($line) !== trim($city)) {
          $pdf->MultiCell(0,5,$line);
        }
      }
      if (trim($line) == '=====') {
        $readingCityData = false;
      }
    }
    fclose($handle);
  }
  $pdf->SetFont('Times','',12);

  $paragraphs = [];

  $paragraphs[] = 'This list is for the personal use by the receiver from AA Affordable Arlington Realty (ADFW Metro Realty) for the use as a Broker to client use for considering and if interested to place a contract on any address to be written and submitted by an AA Affordable Realty Buyers Broker for buyers submitting contracts on addresses from this list and all lists by this Realty. No address may be used for any other purpose without written consent. There is no co-broker agent fee for any other person. Local, state and federal laws apply on any address on this list or any list that these addresses would appear from this list.';

  $paragraphs[] = 'ASK FOR AN UPDATED LIST of a city, please e-mail or phone request for the most current address list meeting your pre qualifcation to be sent to you after completing the Question Form found from under the: Forms, Tips & Info (Aheading button).';

  $paragraphs[] = 'AA Affordable Realty offers a FREE Realty consulting frst session for buyers, sellers and also an exclusive one for all renters. Use this frst Free session that has additional saving Free money extra to any transaction explained for your information. A Free session may be given optional over the phone by appointment.';

  $bottomParagraph = 'Information accuracy reproduced as received';

  foreach ($paragraphs as $paragraph) {
    $pdf->SetY($pdf->GetY() + 5);
    $pdf->MultiCell(0, 5, $paragraph, 0, 'J');
  }

  $pdf->SetY($pdf->GetY() + 5);
  $pdf->SetFont('Times','B',12);
  $pdf->MultiCell(0, 5, $bottomParagraph, 0, 'C');
  $pdf->SetFont('Times','',12);

  $pdf->Output('I', 'Housing Listings - ' . date("m-d-Y") . ' (' . $city . ').pdf');
} else if (array_key_exists('re-consulting', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  $pdf->SetTitle('Real Estate Consulting');

  $pdf->SetFont('Times','B',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'REAL ESTATE CONSULTANT (A FREE SESSION)', 0, 'C');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, date('m/d/Y') . ' tsp AA Affordable Realty', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'Free session may be scheduled to receive by phone. Please before you make any transaction by signing any papers (read the AA Affordable website pertaining to a real estate consultant. Ask how AA Affordable can protect your interests guaranteed to save you money. Once a signature is applied to any document with out asking for a free consultant session or an attorney to review your document could be a very costly financial error with the over sight could be very costly as it in most cases . The risk is to great to check by first asking a few free questions before putting a signature on any written contract.', 0, 'J');

  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 15);
  $pdf->MultiCell(0, 5, 'Information accuracy reproduced as received.', 0, 'C');

  $pdf->Output('I', 'Real Estate Consulting.pdf');
} else if (array_key_exists('tax-reduction', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  $pdf->SetTitle('Tax Reduction');

  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'PROPERTY TAX REDUCTION', 0, 'C');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 1);
  $pdf->MultiCell(0, 5, 'Special List-', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, date('m/d/Y') . ' AA Affordable Realty (aka: AA Affordable Arlington DFW Metro Realty).' . PHP_EOL .
    '"Since 1991 experienced in service to the DFW Metro Plex, North, East & all of Texas"', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, '"HUD/VA approved 26 years. Authorized sales & purchases over 41 years Texas R,E. Licensed".', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'AA Affordable Realty offers service to reduce a property tax yearly on all Texas resident dwellings.', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'First notification to a tax district must be made approximate May 1 & not later than the third week in May to be effective for the following year taxes. The sooner to contact the tax district will result with a more desired reduction. If necessary , for a contested desired reduction , a request before June 1 for a scheduled date for a hearing is required. If no contact is made to the tax district before June 1st than the results would not be effective until the following year.', 0, 'J');

  $pdf->SetFont('Times','BU',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'AA Affordable Realty offers a FREE Realty consulting first session for Buyers, Sellers and a special one for any residential tax reduction . Use this first Free session that may optional be scheduled to be received by phone and explains how to receive Free funding minus expense after closing funding not related to any closing expenses.', 0, 'J');

  $pdf->SetFont('Times','BU',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'This firm by both yearly education & real estate experience is qualified to lower any RE taxes in Texas. Free savings quote given on any residential estate in Texas.', 0, 'J');

  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'Information accuracy reproduced as received.', 0, 'C');

  $pdf->Output('I', 'Tax Reduction.pdf');
} else if (array_key_exists('re-insurance', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  $pdf->SetTitle('Real Estate Insurance');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'txx INSURANCE, ALL COVERAGE TYPES-PERSONAL-SAVINGS-LIABILITY-MORTGAGE PROTECTION-ETC.', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'Insurance coverage is a mutual owned by all policy holders that are owner members that enjoy savings by lower insurance payments fit to a policy holders needs. Interest on payments paid are applied to most policies and accumulate additional cash value to the policy or it is also an account that has cash value that can be used by the policy holder any cash needs', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, '(FREE ANALYSIS for personal financial protection that includes Free cash savings from the insurance payments of protection.).', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'The analysis requires less than 15 minutes to evaluate and requires no obligation to purchase without personal approval. Easy payment plans for protection is available and also many side free benefits not related to insurance is available to the policy holder plus any family members).', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'A variety of policies are available without any health exams required. A few policies may be up graded coverage and upgrade to another policy without change in age requirements that are locked from the previous policies', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'All payments received from any policy insured coverage is income tax free from any IRS yearly tax reports.', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, date('m/d/Y') . ' txx AA Affordable Realty', 0, 'J');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'Information accuracy reproduced as received', 0, 'C');

  $pdf->Output('I', 'Real Estate Insurance.pdf');
} else if (array_key_exists('pre-mortgage', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  $pdf->SetTitle('Pre-Mortgage Certification');

  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'PRE-MORTGAGE APPLICATION FORM', 0, 'C');

  $pdf->SetFont('Times','B',10);
  $pdf->SetY($pdf->GetY() + 8);
  $pdf->MultiCell(0, 5, 'THE GOVERNMENT REQUIRES THE INFORMATION ASKED ON THE PREQUAL FORM TO BE COMPLETED BY EACH OF THE BUYERS ON A SEPARATE FORM IF THE LAST NAME IS DIFFERENT AND THE BUYERS MAY IN THE FUTURE WANT TO SUBMIT A CONTRACT OF PURCHASE ON A GOVERNMENT OWNED HOME WHICH IS THE MOST REASONABLE TYPE TO PURCHASE BECAUSE OF ALL THE BENEFITS.', 0, 'J');

  $pdf->SetFont('Times','BU',10);
  $pdf->SetY($pdf->GetY() + 2);
  $pdf->MultiCell(0, 5, 'BEFORE ANYONE IS PERMITTED TO SUBMIT A CONTRACT BY THE CERTIFIED BROKER, THE GOVERNMENT UNDERWRITER MUST HAVE BEEN FURNISHED THE FORM TO DETERMINE THE QUALIFICATIONS OF EACH PURCHASER AND A CERTIFICATION WILL BE ISSUED THAT MUST ACCOMPANY AN OFFER OF CONTRACT OR THE CONTRACT WILL NOT BE.', 0, 'J');

  $pdf->SetFont('Times','B',10);
  $pdf->SetY($pdf->GetY() + 2);
  $pdf->MultiCell(0, 5, 'THIS IS THE FIRST NECESSARY STEP TO BECOME ELIGIBLE TO SUBMIT A CONTRACT AND ALSO WILL GUIDE THE BUYER IN THE RIGHT PRICE RANGE OF ONLY ADDRESSES OFFERED WITHIN THAT PRICE RANGE. THERE IS NO COST OR OBLIGATION BY COMPLETING THE NECESSARY BLANKS OF THE CONFIDENTAL FORM USED TO GET THE CERTIFICATION.', 0, 'J');

  $pdf->SetFont('Times','BU',10);
  $pdf->SetY($pdf->GetY() + 2);
  $pdf->MultiCell(0, 5, 'RETURN THE FORM WITHOUT DELAY. YOU WILL BE FURNISHED ALL ADDRESSES AND CONTINUE TO BE FURNISHED ANY ADDITIONAL ADDRESSES THAT BECOMES AVAILABLE IN YOUR PRE QUALIFIED PRICE RANGE THE GOVERNMENT UNDERWRITER HAS ESTABLISHED BASED ON THE INFORMATION YOU HAVE FURNISHED ON THE FORM YOU SUBMITTED.', 0, 'J');

  $pdf->SetFont('Times','BU',12);
  $pdf->SetY($pdf->GetY() + 10);
  $pdf->MultiCell(0, 5, 'AA Affordable Realty offers a FREE telephone consulting session for Buyers, Sellers and Renters. Use this free offer.', 0, 'J');

  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 10);
  $pdf->MultiCell(0, 5, 'Information accuracy reproduced as received.', 0, 'C');

  $pdf->Ln(100);
  $pdf->SetFont('Courier','',8);
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->MultiCell(0, 5,
    'Date: ____ / ____ / ____                                                  To:__________________________________', 0, 'J');
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->SetFont('Courier','B',8);
  $pdf->MultiCell(0, 5, 'AA Affordable Realty', 0, 'C');
  $pdf->SetFont('Courier','',8);
  $pdf->MultiCell(0, 4,
    'Mailing Address:                                                          Office:' . PHP_EOL .
    'P.O. Box 1803                                                             Eugene Havran' . PHP_EOL .
    '300 South Street                                                          (817) 296-2400' . PHP_EOL .
    'Arlington, TX 76004                                                       eugene.havran@gmail.com'
);


  $pdf->SetFont('Times','BU',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'PRE-MORTGAGE APPLICATION FORM', 0, 'C');
  $pdf->SetFont('Courier','',8);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 6,
    'BUYER _________________________________________________________      SS# ______-______-_______     AGE _______' . PHP_EOL .
    '2nd BUYER _____________________________________________________      SS# ______-______-_______     AGE _______' . PHP_EOL
  );

  $pdf->SetFont('Times','',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, '(Separate Application Form for each person other than spouse.)', 0, 'C');

  $pdf->SetFont('Courier','',8);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 4,
    'ADDRESS _______________________________________________________      CITY ____________________     ZIP _______' . PHP_EOL .
    'HOME PHONE ___________________________    WORK ____________________________    FAX ___________________________' . PHP_EOL .
    '                                2ND BUYER WORK ____________________________    FAX ___________________________' . PHP_EOL .
    'AGES OF DEPENDENTS __________________________________________     RENT OR HOUSE PMT __________________________' . PHP_EOL .
    'LEASE EXPIRED ( YES / NO )        If "YES", date expired _______________________' . PHP_EOL .
    'GROSS MONTHLY INCOME BORROWER $________________    CO-BORROWER $________________' . PHP_EOL .
    '' . PHP_EOL .
    'VERIFIED FROM W-2 OR 1099 FORMS, FROM SELF EMPLOYED NEED 2 YEARS INCOME TAX & PL' . PHP_EOL .
    '' . PHP_EOL .
    'BUYER EMPLOYER ________________________________________________________  # MONTHS ____________________________' . PHP_EOL .
    '2ND BUYER EMPLOYER ____________________________________________________  # MONTHS ____________________________' . PHP_EOL .
    '' . PHP_EOL .
    'Need 24 month work history of each buyer, use extra page if necessary.' . PHP_EOL .
    '' . PHP_EOL .
    'EXTRA INCOME BORROWER __________________________________   CO-BORROWER _______________________________________' . PHP_EOL .
    '' . PHP_EOL .
    'CURRENT               MONTHLY                    MINIMUM                   Fill out only if 10 months or less.' . PHP_EOL .
    'DEBTS                 ACCOUNTS OWED              MONTHLY PAY               BALANCE LEFT' . PHP_EOL .
    '' . PHP_EOL .
    '___________________   ________________________   _______________________   ___________________________' . PHP_EOL .
    '' . PHP_EOL .
    '___________________   ________________________   _______________________   ___________________________' . PHP_EOL .
    '' . PHP_EOL .
    '___________________   ________________________   _______________________   ___________________________' . PHP_EOL .
    '' . PHP_EOL .
    '___________________   ________________________   _______________________   ___________________________' . PHP_EOL .
    '' . PHP_EOL .
    '___________________   ________________________   _______________________   ___________________________' . PHP_EOL
  );

  $pdf->SetFont('Times','',10);
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->MultiCell(0, 5, '(PLEASE USE BACK OF FORM IF ADDITIONAL SPACE IS NEEDED.)', 0, 'C');

  $pdf->SetFont('Times','',10);
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->MultiCell(0, 5,
    'THE ABOVE INFORMATION IS TRUE & CORRECT TO THE BEST OF MY/OUR KNOWLEDGE' . PHP_EOL .
    '' . PHP_EOL .
    'I HEREBY GIVE AFFORDABLE REALTY AND ITS GOVERNMENT AGENTCIES ASSIGNS PERMISSION TO REVIEW MY CREDIT WITH A CONSUMER CREDIT THAT IS CONFIDENTAL AND WILL NOT BE RELEASED FOR ANY OTHER USE.',
    0, 'J');
  $pdf->SetFont('Courier','',8);
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->MultiCell(0, 3,
    '_______________________________________________                _______________________________________________' . PHP_EOL .
    'BORROWER                                                       CO-BORROWER');

/*

THE ABOVE INFORMATION IS TRUE & CORRECT TO THE BEST OF MY/OUR KNOWLEDGE
I HEREBY GIVE AFFORDABLE REALTY AND ITS GOVERNMENT AGENTCIES ASSIGNS PERMISSION TO REVIEW MY CREDIT
WITH A CONSUMER CREDIT THAT IS CONFIDENTAL AND WILL NOT BE RELEASED FOR ANY OTHER USE.
__________________________
BORROWER
____________________________
CO-BORROWER


*/
  $pdf->Output('I', 'Pre-Mortgage Certification.pdf');
} else if (array_key_exists('question-form', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  $pdf->SetTitle('Question Form');

  $pdf->SetFont('Times','B',15);
  $pdf->SetY($pdf->GetY() + 2);
  $pdf->MultiCell(0, 5, 'Complete and Submit The Following Questionnaire to Show a Property', 0, 'C');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'ALL DATA FROM THIS FORM WILL BE ENTERED IN THE COMPUTER TO CROSS CHECK AGAINST THE WEEKLY INVENTORY OF VACANT HOMES THAT MEET YOUR NEEDS AND NOTIFY YOU IF POSSIBLE. TO CONTINUE RECEIVING ADDRESSES ALL CRITERIA (TO ANSWER THE FORM) IS NECESSARY', 0, 'J');

  $pdf->SetFont('Courier','',8);
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->MultiCell(0, 5, 'Date: ____ / ____ / ____', 0, 'J');
  $pdf->SetY($pdf->GetY() + 3);
  $pdf->MultiCell(0, 4,
    'Applicant: Full First, MI & Last Name: ________________________________________________________________________' . PHP_EOL .
    '2nd applicant adult : Full First, MI & Last Name:______________________________________________________________' . PHP_EOL .
    'Each age of child (boy or girl) _______________________________________________________________________________' . PHP_EOL .
    'HOME Address___________________________________________City and zip____________________________________________' . PHP_EOL .
    'HOME PHONE no. ________________________________________Cell no.________________________________________________' . PHP_EOL .
    'EMAIL _________________________________________________________________________________________________________' . PHP_EOL .
    'WORK  DAYS  ___________________________________________________________________________________________________' . PHP_EOL .
    'NIGHT OR DAY SHIFT_______________WORK ADDRESS__________________________________________________________________' . PHP_EOL .
    'WORK CITY and zip______________________________________________________________________________________________' . PHP_EOL .
    'WORK phone and ext. # _________________________________________________________________________________________' . PHP_EOL .
    'LIST ALL CITIES INTERESTED AND LIST SPECIFIC AREA OF THE CITY IF APPLICABLE ___________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    'SPECIFIC NEEDS SUCH AS MORE THAN 2 BEDROOMS, ___ 3BR___4BR___, FORMAL EATING_____, CLOSE TO SCHOOLS_____,' . PHP_EOL .
    'EXTRA ROOM_____, ONE OR TWO STORY ACCEPTABLE__________ EXTRA AUTO PARKING _______' . PHP_EOL .
    'ETC.___________________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    'MONTHLY PAYMENT RANGE _______________________CASH FOR FIRST MONTH, and SECURITY DEPOSIT ON HAND OR AVAILABLE IN' . PHP_EOL .
    'BANK yes or no_____  IN SAVINGS yes or no___________  FUTURE CASH EXTRA  yes or no._______' . PHP_EOL .
    'OWN LAWN MOWER yes or no______________  OWN FLOOR VACUUM CLEANER yes or no________' . PHP_EOL .
    'What date are you capable for your start move in date _________________________________________________________' . PHP_EOL .
    'Do you own pets yes or no___________  How many autos__________  Any motor bikes, boats, trailers, etc.' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    'Comments: _____________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________' . PHP_EOL .
    '_______________________________________________________________________________________________________________', 0, 'J');

    $pdf->SetFont('Times','B',10);
    $pdf->SetY($pdf->GetY() + 5);
    $pdf->MultiCell(0, 5, 'PLEASE COMPLETE and mail, or email back w/o delay that all available information can be sent to you and to schedule a showing that meets your needs. Mailing Address: 300 South Street, P.O. Box 1803, Arlington, TX 76004 Please phone Eugene Havran, Broker Owner, AA AFFORDABLE Realty at Phone. 817-468-1313 ; (Business Hours Only, if possible to talk to the broker); e mail: eugene.havran@gmail.com', 0, 'J');

    $pdf->SetFont('Times','B',10);
    $pdf->SetY($pdf->GetY() + 5);
    $pdf->MultiCell(0, 5,
      'AA Affordable Realty offers a Free consulting telephone appointment for each seperate, Buyers, Sellers and a special ' .
      'one for Renters. Use this Free consulting appointment. NOTE: FOR A PURCHASE OR SELL to phone and acknowledged in ' .
      'writing the referral names with a phone number we award either $500.00 or $1,000.00 based also on closing price after ' .
      'funding and expense from each for a sell or purchase for the acknowledged referral. Ask how this applies for you to ' .
      'receive by phoning in a prospects full name, phone number and for each additional for each referral an extra amount ' .
      'for two or more good phone numbers for each referral.', 0, 'J');

    $pdf->SetFont('Times','BU',10);
    $pdf->SetY($pdf->GetY() + 5);
    $pdf->MultiCell(0, 5, 'Leave any question on the form blank if it is unknown or there is a question with a complete answer.', 0, 'C');

  $pdf->Output('I', 'Question Form.pdf');
} else if (array_key_exists('testimonials', $_GET)) {
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Times','',12);
  $pdf->SetTitle('Testimonials');

  $pdf->SetFont('Times','B',12);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, date("m/d/Y"), 0, 'J');

  $pdf->SetFont('Times','B',15);
  $pdf->SetY($pdf->GetY() + 5);
  $pdf->MultiCell(0, 5, 'TESTIMONIALS', 0, 'C');

  $pdf->SetFont('Times','',12);
  $pdf->SetY($pdf->GetY() + 15);
  $pdf->MultiCell(0, 5, '(Ask for the city that your interested for the testimonials for that city or area close to the interested address you are interested.)', 0, 'J');

  $pdf->Output('I', 'Testimonials - ' . date('m-d-Y') . '.pdf');
} else {
  echo 'PDF not selected.';
}
