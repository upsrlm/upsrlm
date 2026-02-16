<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use common\models\User;
use yii\bootstrap4\Modal;
use common\models\master\MasterRole;

$this->title = 'Partners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1><?= $this->title ?></h1>
      </div>
    </div>
  </div>
</div>
<div style="min-height: 400px">
  <div class="testimonials texti pt-5 mt-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/BankOfBarodaLogo.svg.png" alt="" class="m-0">
                  <div class=""> <a href="">https://bankofbaroda.in/ </a></div>
                  <span class="text_formate">The top-ranked banking partner, covers 15 districts of the State: Spreads across 13,186 GPs at one BC Sakhi every GP.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>Bank of Baroda</h4>
                  <p>"Bank of Baroda (BOB or BoB) is an Indian Multinational public sector bank headquartered in Vadodara, Gujarat. It is the second largest public sector bank in India after State Bank of India, with 153 million customers, a total business of US$218 billion, and a global presence of 100 overseas offices. Based on 2023 data, it is ranked 586 on the Forbes Global 2000 list. The Maharaja of Baroda, Sayajirao Gaekwad III, founded the bank on 20 July 1908 in the princely state of Baroda, in Gujarat. The Government of India nationalized the Bank of Baroda, along with 13 other major commercial banks of India, on 19 July 1969 and the bank was designated as a profit-making public sector undertaking (PSU)."</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/Finodwqfwefwefgb.jpg" alt="" class="m-0">
                  <div class="d">
                    <a href="https://web4.finobank.com/" target="_blank">https://web4.finobank.com/ </a>
                  </div>
                  <span class="text_formate">The 2nd-ranked banking partner, covers 7 districts of the State: Spreads in approx. 6,000 GPs at one BC Sakhi every GP.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>FINO Payment Bank</h4>
                  <p>"With 16.95 Lakhs distribution points offering quality banking services across 97% of India’s PIN CODE, FINO Payments Bank is truly India’s local national bank. The preferred banking option for over a crores hard working Indian’s, FINO now digitizes 24 Lakh of cash every minute, thus giving a boost to India’s digital payment push. At 1.23% of India’s ever expanding UPI ecosystem FINO is ringing in adoption of digital banking with its #FikarNot brand of #HardinFino banking services FINO Payments Bank is India’s only listed Payments Bank and invested into the consumer’s life by offering access to quality banking service, seamlessly- physically and digitally."</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/paynerby.webp" alt="" class="m-0">
                  <div class="d">
                    <a href="https://paynearby.in/" target="_blank">https://paynearby.in/ </a>
                  </div>
                  <span class="text_formate">The 3rd-ranked banking partner, covers 9 districts of the State: Spreads in approx. 10,209 GPs at one BC Sakhi every GP.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>Pay Nearby</h4>
                  <p>"Nearby endeavours to empower local retail stores through our Distribution-as-a-Service (DaaS) network, enabling them to provide digital and financial services to the citizens of Bharat. It’s mission is to make financial & digital services available to everyone, everywhere. Through tech-led DaaS network, Nearby is serving 75% of India; it facilitates various services including cash withdrawal, bank account opening, money transfer, recharge, assurance (insurance + assets), credit, and e-commerce. With over 12 lakh micro-entrepreneurs across 22,000 PIN codes serving 50+ crore customers across the country to the tune of more than ~ INR 8000/- crores Gross Transaction Value (GTV) per month. "</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/manipal-1602141412.jpeg" alt="" class="m-0">
                  <div class="d">
                    <a href="https://manipaltechnologies.com/" target="_blank">https://manipaltechnologies.com/ </a>
                  </div>

                  <span class="text_formate">The next-ranked banking partner, covers 16 districts of the State: Spreads in approx. 8,122 GPs at one BC Sakhi every GP.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>Manipal Technology Ltd. </h4>
                  <p>"Manipal Technology Ltd is an organization with 80 Years of rich experience. Manipal provides leading technology, digital print and solution provider to all leading Public and Private Banks with turnover of 2 Billion USD. We provides services to the banks trough India largest Card Manufacturing Unit, India largest Commercial Print division and secure printing division for cheque book statement and hologram printing. We Also provide services for online examination for various government and universities. We work with all leading banks for financial inclusion in PAN India with 9000+ BC 24,000 villages."</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/airtel.webp" alt="" class="m-0">
                  <div class="d">
                    <a href="https://www.airtel.in/bank/" target="_blank">https://www.airtel.in/bank/ </a>
                  </div>

                  <span class="text_formate">The next banking partner, covers 9 districts of the State: Spreads in approx. 5,710 GPs at one BC Sakhi every GP.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>Airtel Payment Bank Limited </h4>
                  <p>"Airtel Payments Bank, the first payments bank to commence operations in Nov 2016, has enabled easy and simple access to banking services with the vision to touch “Every Mile, Every family, every Business” and contribute to the government of India’s vision of digital India and Financial inclusion. With its nation-wide presence, the bank has built robust banking network of 5 million banking points including over 40,000 in unbanked remote geographies, delivering seamless digital as well as feature phone banking. with a strong distribution network and easy, paper less services today the bank is serving more than 3 million people across the country to receive DBT in their bank account. The bank’s on-ground BC Sakhi network has also enabled doorstep services for women, elderly and specially-abled, to facilitate safe banking from home at this time across, in Indian States of Uttar Pradesh, Madhya Pradesh, Chhattisgarh, Bihar, Rajasthan, North East States, Telengana and Gujarat."</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/rsetilogo - Copy.jpg" alt="" class="m-0">
                  <div class="d">
                    <a href="https://rudsetacademy.org" target="_blank">https://rudsetacademy.org </a>
                  </div>

                  <span class="text_formate">RSETI was assigned to train 58000 BC Sakhis to enable certification of Indian Institute of Banking & Finance (IIBF). RSETI despite restrictions imposed during the COVID19 pandemic, so far trained more than 50,000 BC Sakhis. The second role of RSETI is to conduct review of BC Sakhi performances after deployment by partner banks.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>RSETI </h4>
                  <p>"Banking in India, as it aims to offer responsible and sustainable Banking In Uttar Pradesh 75 RSETIs are functional and imparting quality training to rural unemployed youth of the State. Since its inception, RSETIs have trained 644,424 candidates out of which 468,904 are successfully settled through various self-employment ventures. As a training agency for One GP One BC Sakhi programme, 51,465 BC Sakhis have been trained by these RSETIs and certified by IIBF. Its National counterpart, National Academy of RUDSETI (NAR), is a resource organization committed to Entrepreneurship Development through motivation, training and facilitation. It has been effective in motivating the un-employed youth to take up self-employment as a career option. This has enabled to convert a large chunk of latent human resources into productive assets in the country. National Academy of RUDSETI (NAR), is spearheading the concept by Training the Trainers/ facilitators and mentoring the Rural Self Employment Training Institutes (RSETIs) established across the country. "</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/sbi.png" alt="" class="m-0">
                  <div class="d">
                    <a href="https://www.onlinesbi.sbi/" target="_blank">https://www.onlinesbi.sbi/</a>
                  </div>

                  <span class="text_formate">Inducted as replacement of Paytm Payment Bank due to regulatory reasons, SBI is the largest public sector Bank in India; has been assigned 19 districts to cover 9,918 GPs at one BC Sakhi for each GP.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>State Bank of India </h4>
                  <p>"State Bank of India (SBI) a Fortune 500 company, is an Indian Multinational, Public Sector Banking and Financial services statutory body headquartered in Mumbai. The rich heritage and legacy of over 200 years, accredits SBI as the most trusted Bank by Indians through generations. SBI, the largest Indian Bank with 1/4th market share, serves over 48 crore customers through its vast network of over 22,405 branches, 65,627 ATMs/ ADWMs, 76,089 BC outlets, with an undeterred focus on innovation, and customer centricity, which stems from the core values of the Bank - Service, Transparency, Ethics, Politeness and Sustainability. The Bank has successfully diversified businesses through its various subsidiaries i.e. SBI General Insurance, SBI Life Insurance, SBI Mutual Fund, SBI Card, etc. It has spread its presence globally and operates across time zones through 235 offices in 29 foreign countries. Growing with times, SBI continues to redefine"</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/pcs.png" alt="" class="m-0">
                  <div class="d">
                      <a href="https://pciglobal.in/" target="_blank">https://pciglobal.in/ </a>
                  </div>

                  <span class="text_formate">Vide a formal arrangement with Govt. of Uttar Pradesh, and with assistance from Bill & Melinda Foundation, PCI Global assisted conceptualization & thematic development of the BC Sakhi program 1.0. Later, PCI entered into an MoU with Govt. of UP to take forward the program to capture & flourish direct benefits transfer (DBT) of schematic services of State & Central Govt.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>PCI Global </h4>
                  <p>"PCI India, established in 1998, pioneers impactful interventions addressing complex social issues through strategic partnerships and evidence-based solutions. With deep community engagement, it uncovers root causes and designs scalable programmes for marginalised communities. Recognised for its high-quality technical assistance, PCI collaborates with governments and development organisations, transforming lives at scale. Through rigorous measurement and efficacy, it drives sustainable change in India's social landscape."</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-3">
          <div class="testimonial-item bg-white p-4">
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="text-center">
                  <img src="/images/trilinelogo.png" alt="" class="m-0">
                  <div class="d">
                    <a href="https://trilineinfotech.com" target="_blank">https://trilineinfotech.com/ </a>
                  </div>

                  <span class="text_formate">Triline is the Technology-agency for UPSRLM, Government of Uttar Pradesh that has conceived the technology platform, developed end-to-end and innovated a host of digital products that suit the rural audience from the underbanked segment.</span>
                </div>

              </div>
              <div class="col-md-8">
                <div class="text-start">
                  <h4>Triline InfoTech </h4>
                  <p>"Triline Infotech is a registered Company in India with a team of IT professionals that believe in evincing quality and cost-effective web-solutions. Its clients range from largest of State governments, large firms to the smaller ones. Triline team works in a collaborative manner to provide vanguard technical solutions to generate positive outcomes in the internet industry for the enterprise solutions. It offers quality services to suffice clients’ service-needs, both for quality and service. As a creative team of veterans, we know exactly what it takes to create an"</p>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>