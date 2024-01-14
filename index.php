<!DOCTYPE html>
<html lang="en">

<head>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "finvestia",
            "logo": "./images/logo.png",
            "url": "https://www.finvestia.co.ke"
        }
    </script>
    <title>finvestia.co.ke</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./welcomeimport.css">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <!-- <link href="css/style.css" rel="stylesheet"> -->
</head>

<script>
    function hello() {
        let det = document.querySelector('.detail-container');
        det.classList.toggle('expandedd'); // Toggle the 'expandedd' class on the container

        if (det.classList.contains('expandedd')) {
            document.getElementById('expandbtn').innerHTML = "Read Less";
        } else {
            document.getElementById('expandbtn').innerHTML = "Read More";
        }
    }

    function investToggle() {
        let det = document.querySelector('.investia');
        det.classList.toggle('expandedd'); // Toggle the 'expandedd' class on the container

        if (det.classList.contains('expandedd')) {
            document.getElementById('expandbtn1').innerHTML = "Read Less";
        } else {
            document.getElementById('expandbtn1').innerHTML = "Read More";
        }
    }

    function contExpand() {
        let det = document.querySelector('.conta');
        det.classList.toggle('expandedd'); // Toggle the 'expandedd' class on the container

        if (det.classList.contains('expandedd')) {
            document.getElementById('expandbtn2').innerHTML = "Read Less";
        } else {
            document.getElementById('expandbtn2').innerHTML = "Read More";
        }
    }
</script>

<body style="background-color: black;">
    <div class="container">
        <div class="header">
            <div class="logodetails">
                <img src="./images/logo.png" alt="not found" class="logo" />

                <h2 class="logo-name">fin<span>Vestia</span></h2>
            </div>

            <div id="links">
                <ul>
                    <li>
                        <a href="#home">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="#about">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="#investment">
                            Investment
                        </a>
                    </li>
                    <li>
                        <a href="#review">
                            Reviews
                        </a>
                    </li>
                    <li>
                        <a href="#blogs">
                            Blogs
                        </a>
                    </li>
                    <li>
                        <a href="#contactus">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>
            <div class="forLinks">

            </div>
            <div class="login_area">
                <a href="./login.php">
                    <button>
                        LOGIN
                    </button>
                </a>
            </div>
        </div>

        <!-- home -->
        <div id="home" class="home" style="padding: 5px; margin-top:5rem;">
            <div class="left">
                <div class="detail">

                    <span class="welcome" style="color:var(--secondary);">Welcome to finVestia!</span><br>

                    <span class="par">
                        We are thrilled to have you here. As a leading provider of financial
                        solutions, we are committed to helping you achieve your financial
                        goals and aspirations. At finVestia, we prioritize your success and
                        financial well-being. Explore our range of services, get to know our
                        exceptional team, and embark on a rewarding partnership with us.
                        Together, let's unlock the path to financial prosperity.
                    </span>

                    <p style="color:var(--secondary);">With a rich history dating back to 2018, finVestia has been at the
                        forefront of the industry for 5 years. Our longstanding presence is a
                        testament to our expertise, commitment, and trustworthiness.
                        Experience the advantage of partnering with a company that has stood
                        the test of time.</p>
                </div>
            </div>

            <div class="right">
                <img src="./Assets/bg14.png" class="" alt="None found"></img>
            </div>
        </div>
        <!-- about us -->
        <div class="aboutus" id='about'>
            <div class="heading">
                <h2>About Us</h2>
            </div>

            <div class="cards">

                <div class="icons">

                    <div class="flex">
                        <i class="fa-solid fa-arrow-trend-up"></i>

                        <h3>140+</h3>
                    </div>
                    <p>Customized Investment Solutions</p>
                </div>

                <div class="icons">
                    <div class="flex">
                        <i class="fa-solid fa-check"></i>
                        <h3>1040+</h3>

                    </div>
                    <p>Client Success Stories</p>

                </div>

                <div class="icons">
                    <div class="flex">
                        <i class="fa-sharp fa-solid fa-file-invoice-dollar"></i>
                        <h3>500+</h3>
                    </div>
                    <p>Comprehensive Financial Solutions</p>

                </div>

                <div class="icons">
                    <div class="flex">
                        <i class="fa-solid fa-users"></i>
                        <h3>8000+</h3>
                    </div>
                    <p>Client Recommendations</p>
                </div>

            </div>
            <div class="mostprestigous">
                <div class="imgprestigous">
                    <img src="./Assets/aboutInvestment.png" alt='no img'></img>
                </div>

                <div class="prestigousdetails">
                    <h2 class="prestigousHeading">
                        The most prestigous Investment company in the world.
                    </h2>

                    <p>
                        As the most prestigious investment company in the world, finVestia has earned its esteemed reputation through a combination of exceptional qualities and achievements.
                        As the most prestigious investment company in the world, finVestia combines a sterling reputation, an unparalleled track record, a commitment to excellence, unrivaled expertise, a client-centric approach, cutting-edge technology, and influential thought leadership. Partnering with us means gaining access to the very best in investment management and unlocking the potential for exceptional financial success.
                    </p>

                    <div class="secure_online">
                        <div class="secure_online_icon">

                            <i class="fa-solid fa-lock"></i>
                        </div>

                        <div class="secure_online_details">
                            <h4>Secure investments</h4>
                            <p>At finVestia, we prioritize the safety and security of our clients' investments above all else. We understand that entrusting your hard-earned money to an investment company requires confidence and peace of mind. Here are a few reasons why we are a secure investment company:Regulatory Compliance,Diversification and Risk Management among others</p>

                        </div>
                    </div>

                    <div class="secure_online">
                        <div class="secure_online_icon">
                            <i class="fa-solid fa-thumbs-up"></i>
                        </div>
                        <div class="secure_online_details">
                            <h4>Higher success Rate</h4>
                            <p>At finVestia, we pride ourselves on our consistently high success rate when it comes to investments. Our consistently high success rate is a testament to our commitment to excellence, expertise, customized strategies, risk management, and proactive approach. We strive to maintain this track record and continue delivering exceptional results for our valued clients. Partner with us and experience the benefits of our higher success rate as we work together to achieve your financial goals.</p>
                        </div>
                    </div>

                </div>

            </div>


        </div>

        <!-- investments -->
        <div class="investmentBody" id="investment">
            <div>
                <div class="Heading">
                    <h2>All About Investment</h2>
                </div>
                <div>
                    <div class="investia">
                        <p class="inv" style=" color:gray;font-size: .8rem;">
                            At finVestia, we understand that every investor has unique financial
                            goals and risk preferences. That's why we offer a range of
                            investment packages designed to suit varying investment needs. Our
                            three packages - Gold, Silver, and Bronze - provide opportunities
                            for consistent returns while aligning with different risk appetites.
                            Let's explore each package in detail: <br></br>Gold Package: Our
                            Gold Package is tailored for investors seeking higher profit
                            potential. With this package, you can enjoy a 30% profit on your
                            investment every week. This aggressive growth strategy is ideal for
                            those who are comfortable with higher risk and are looking to
                            maximize their returns. The Gold Package offers a compelling
                            opportunity for investors with a long-term perspective and an
                            appetite for growth.<br></br>
                            Silver Package: Our Silver Package strikes a balance between risk
                            and reward. With this package, you can expect a 20% profit on your
                            investment every week. The Silver Package provides a moderate level
                            of risk while still offering attractive returns. It is well-suited
                            for investors who desire consistent growth but prefer a more
                            cautious approach compared to the Gold Package.<br><br> Bronze Package: For
                            investors seeking a more conservative investment approach, our
                            Bronze Package offers stability and steady returns. With this
                            package, you can earn a 16% profit on your investment every week.
                            While the returns may be lower compared to the Gold and Silver
                            Packages, the Bronze Package provides a lower-risk investment option
                            for those who prioritize capital preservation and prefer a more
                            predictable income stream.
                            <br><br>
                            Additionally, we are excited to announce that regardless of the package you choose, all profits will be compounded at an impressive rate of 50% every month. This means that your investment has the potential to grow significantly over time, amplifying the returns and enabling you to achieve your financial goals faster.

                            At finVestia, we prioritize transparency and work diligently to ensure the security of our investors' funds. We employ robust risk management strategies, conduct thorough market analysis, and leverage our expertise to make informed investment decisions on your behalf. Our dedicated team of professionals is committed to providing you with exceptional service, regular updates, and personalized support throughout your investment journey.

                            We invite you to explore our investment packages - Gold, Silver, and Bronze - and choose the one that aligns with your investment objectives and risk tolerance. Whether you are seeking aggressive growth, balanced returns, or steady income, we have a package that suits your needs. Contact us today to start your journey towards building wealth and achieving financial success with finVestia.

                        </p>
                    </div>
                    <small style="color: var(--tertiary);" id="expandbtn1" type="button" onclick="investToggle()">Read More</small>

                </div>
            </div>

            <div class="packages">
                <div class="goldPackage">
                    <div class="bestsale">
                        <h5>Best sale</h5>
                    </div>
                    <div class="goldImg">
                        <img src='./Assets/Gold.png' alt="No imaage"></img>
                    </div>
                    <div class="plan">
                        <h3>Gold Plan</h3>
                        <h2>
                            30% <span>weekly</span>
                        </h2>
                    </div>
                    <hr>
                    </hr>
                    <div class="investmentAmount">
                        <div class="minimumInvestment">
                            <h3>Minimum Investment: </h3>
                            <h3> <span>Ksh. 5,000</span></h3>
                        </div>

                        <div class="maximumInvestment">
                            <h3>Maximum Investment: </h3>
                            <h3> <span>Above Ksh. 5,000</span></h3>
                        </div>

                        <div class="avarageInvestment">
                            <h3>Avarage Monthly: </h3>
                            <h3> <span>80%</span></h3>
                        </div>
                    </div>

                    <div class="deposit">
                        <h3>Deposit</h3>
                    </div>
                </div>
                <div class="silverPackage">
                    <div class="bestsale">
                        <h5>Best sale</h5>
                    </div>
                    <div class="silverImg">
                        <img src="./Assets/silver.png" alt="No imaage"></img>
                    </div>

                    <div class="plan">
                        <h3>Silver Plan</h3>
                        <h2>
                            20% <span>weekly</span>
                        </h2>
                    </div>
                    <hr>
                    </hr>
                    <div class="investmentAmount">
                        <div class="minimumInvestment">
                            <h3>Minimum Investment: </h3>
                            <h3><span> Ksh. 2,001</span></h3>
                        </div>

                        <div class="maximumInvestment">
                            <h3>Maximum Investment: </h3>
                            <h3><span> Ksh. 3,999</span></h3>
                        </div>

                        <div class="avarageInvestment">
                            <h3>Avarage Monthly: </h3>
                            <h3> <span>60%</span></h3>
                        </div>
                    </div>

                    <div class="deposit">
                        <h3>Deposit</h3>
                    </div>
                </div>
                <div class="bronzePackage">
                    <div class="bestsale">
                        <h5>Best sale</h5>
                    </div>
                    <div class="bronzeImg">
                        <img src="./Assets/Bronze.png" alt="No image"></img>
                    </div>

                    <div class="plan">
                        <h3>Bronze Plan</h3>
                        <h2>
                            16% <span>weekly</span>
                        </h2>
                    </div>
                    <hr>
                    </hr>
                    <div class="investmentAmount">
                        <div class="minimumInvestment">
                            <h3>Minimum Investment: </h3>
                            <h3> <span>Ksh. 500</span></h3>
                        </div>

                        <div class="maximumInvestment">
                            <h3>Maximum Investment: </h3>
                            <h3> <span> Ksh. 2,000</span></h3>
                        </div>

                        <div class="avarageInvestment">
                            <h3>Avarage Monthly: </h3>
                            <h3> <span>50%</span></h3>
                        </div>
                    </div>

                    <div class="deposit">
                        <h3>Deposit</h3>
                    </div>
                </div>
            </div>


        </div>
        <!-- review -->

        <section class="review" id="review">
            <h1 class="heading">
                client's <span>review</span>
            </h1>
            <p class="details" style="color: gray;">
                These testimonials are just a glimpse of the positive feedback we
                receive from our satisfied clients. We are proud to have earned their
                trust and gratitude through our commitment to excellence and
                personalized service. At finVestia, we remain dedicated to exceeding
                client expectations and delivering exceptional results. We understand
                that each client's journey is unique, and we tailor our services to
                ensure their success in the dynamic world of investments.
            </p>

            <div class="box_container">
                <div class="box">
                    <img src="./Assets/person1.jpg" alt=""></img>
                    <h3>Michael Simiyu</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text">
                        I am thrilled with the results I have achieved since partnering with
                        finVestia. Their deep understanding of the investment market,
                        coupled with their meticulous research and analysis, have proven to
                        be a winning combination. Their transparent reporting and regular
                        updates keep me informed every step of the way." <span>- Michael S</span>.
                    </p>
                </div>

                <div class="box">
                    <img src="./Assets/person2.jpg" alt=""></img>
                    <h3>David Robinson</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text">
                        Working with finVestia has been a game-changer for my investment
                        portfolio. Their expertise and strategic approach have helped me
                        achieve consistent growth and capitalize on lucrative trading
                        opportunities. I have complete confidence in their abilities and
                        highly recommend their services to anyone seeking reliable and
                        profitable investment trading solutions." <span>- David R</span>.
                    </p>
                </div>

                <div class="box">
                    <img src="./Assets/person3.jpg" alt=""></img>
                    <h3>Emma Kavata</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text">
                        The team at finVestia truly goes above and beyond to deliver
                        exceptional service. They are responsive, attentive, and always
                        available to address my questions and concerns. Their commitment to
                        client satisfaction is evident in every interaction, and I am
                        grateful to have them as my trusted investment trading partners."<span> -
                            Emma K</span>.
                    </p>
                </div>
            </div>
        </section>

        <!-- blogs -->
        <section class="blogs" id="blogs">
            <h1 class="heading">

                our <span>blogs</span>
            </h1>

            <div class="blogings">
                <div class="blogImg">
                    <img src="./Assets/investment2.png" alt="none"></img>
                </div>

                <div class="blogDetails" style="margin-top: 50px !important;">
                    <h2>We are the best investment providers in our country</h2>
                    <div class="detail-container">
                        <p class="detail" id="detail" style="color: gray;">
                            At finVestia, we take pride in being recognized as the leading
                            investments trading experts in our country. With a proven track
                            record of success and a deep understanding of the vestia market, we
                            have established ourselves as the go-to destination for individuals
                            and businesses seeking exceptional vestia trading services. Here are
                            a few reasons why we stand out from the competition: <br></br>
                            Extensive Market Knowledge: Our team of vestia traders possesses
                            extensive knowledge and expertise in the investments market. We
                            continuously stay updated on the latest trends, news, and regulatory
                            developments to ensure our clients receive accurate and timely
                            information. This knowledge allows us to make informed trading
                            decisions and provide valuable insights to our clients. <br></br>
                            Proven Trading Strategies: We have developed and refined our trading
                            strategies over years of experience and successful trades. Our
                            strategies combine technical analysis, fundamental analysis, and
                            market sentiment to identify profitable trading opportunities. By
                            employing a disciplined and systematic approach, we aim to maximize
                            returns while effectively managing risk.
                        </p>
                    </div>
                    <small style="color: var(--tertiary);" id="expandbtn" type="button" onclick="hello()">Read More</small>

                    <div class="blogbtns">
                        <h2>
                            Rate us
                        </h2>
                        <h2>
                            Visit us
                        </h2>
                    </div>
                </div>
            </div>

            <div class="box_container">
                <div class="box">
                    <div class="image">
                        <img src="./Assets/invest5.jpg" alt=""></img>
                    </div>
                    <div class="content">
                        <div class="icon">
                            <a href="#">
                                <i></i> 15<sup>th</sup> may, 2021
                            </a>
                            <a href="#">
                                <i></i> The C.E.O
                            </a>
                        </div>
                        <h3>
                            Navigating Market Volatility: Strategies for Successful Investing
                        </h3>
                        <p>
                            Investing in financial markets can be an exhilarating journey,
                            filled with opportunities and challenges. One aspect that often
                            tests the mettle of investors is market volatility. While it can
                            be unnerving, volatility is an inherent characteristic of markets
                            and can provide avenues for potential growth and profit. In this
                            blog post, we will explore some key strategies to navigate market
                            volatility successfully and make informed investment decisions.The
                            area Embrace a Long-Term Perspective,Diversify Your Portfolio and
                            Stick to Your Investment Plan.
                        </p>
                        <a href="#" class="btn">
                            learn more <span></span>
                        </a>
                    </div>
                </div>

                <div class="box">
                    <div class="image">
                        <img src="./Assets/invest6.jpg" alt=""></img>
                    </div>
                    <div class="content">
                        <div class="icon">
                            <a href="#">
                                <i></i> 13<sup>th</sup> october, 2022
                            </a>
                            <a href="#">
                                <i></i> finVestia
                            </a>
                        </div>
                        <h3>
                            Sustainable Investing: Making an Impact While Building Wealth
                        </h3>
                        <p>
                            In recent years, there has been a growing recognition that
                            investing can have a positive impact not only on financial returns
                            but also on the world we live in. Sustainable investing, also
                            known as socially responsible investing or impact investing, is an
                            approach that seeks to generate long-term value by considering
                            environmental, social, and governance (ESG) factors. In this blog
                            post, we will explore the concept of sustainable investing and how
                            you can align your investments with your values while building
                            wealth.
                        </p>
                        <a href="#" class="btn">
                            learn more <span></span>
                        </a>
                    </div>
                </div>

                <div class="box">
                    <div class="image">
                        <img src="./Assets/invest7.jpg" alt=""></img>
                    </div>
                    <div class="content">
                        <div class="icon">
                            <a href="#">
                                <i></i> 1st February, 2023
                            </a>
                            <a href="#">
                                <i></i> Vestia team
                            </a>
                        </div>
                        <h3>The Power of Compound Interest: Unlocking Long-Term Wealth</h3>
                        <p>
                            Compound interest is often hailed as the "eighth wonder of the
                            world" by renowned physicist Albert Einstein. Its ability to
                            exponentially grow your wealth over time is truly remarkable. In
                            this blog post, we will delve into the concept of compound
                            interest and explore how you can harness its power to unlock
                            long-term wealth.
                        </p>
                        <a href="#" class="btn">
                            learn more <span></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact us -->

        <div class="WholeFooter" id="contactus">
            <h2 class="heading">
                Contact Us
            </h2>
            <div class="conta">
                <p class="details" style="color: gray;">
                    Welcome to our Contact Us page! At finVestia, we value open
                    communication and strive to provide exceptional customer service. We
                    believe that every interaction with our clients and visitors is an
                    opportunity to build meaningful relationships and address any inquiries
                    or concerns they may have. Whether you are a current client seeking
                    assistance, a potential investor with questions, or simply interested in
                    learning more about our services, this Contact Us page is designed to
                    make it easy for you to connect with us. We are here to listen, provide
                    guidance, and offer the support you need on your financial journey. Our
                    dedicated team of professionals is committed to ensuring your experience
                    with finVestia is seamless and rewarding. We understand that each
                    individual has unique needs and objectives, and we are ready to tailor
                    our services to meet your specific requirements. By reaching out to us,
                    you take the first step towards accessing personalized solutions that
                    can help you achieve your financial goals. We value your time and aim to
                    respond promptly to all inquiries received through our contact channels.
                    Whether you choose to contact us via phone, email, or by filling out the
                    contact form on this page, rest assured that our team will be readily
                    available to assist you. Thank you for considering finVestia as your
                    trusted partner in financial success. We look forward to hearing from
                    you and starting a mutually beneficial relationship that can guide you
                    towards a brighter and more prosperous future.
                </p>
            </div>
            <small style="color: var(--tertiary);" id="expandbtn2" type="button" onclick="contExpand()">Read More</small>


            <section class="footers">
                <div class="box_container">
                    <div class="box">
                        <h3>quick links</h3>
                        <a href="#home">home</a>
                        <a href="#investment">investments</a>
                        <a href="#about">about us</a>
                        <a href="#review">review</a>
                        <a href="#blogs">blogs</a>
                    </div>

                    <div class="box">
                        <h3>our services</h3>
                        <a href="#investment">Investment Solutions</a>
                        <a href="#investment">Wealth Management</a>
                        <a href="#investment">Mutual Funds Investment</a>
                        <a href="#investment"> Diversification Strategies</a>
                        <a href="#investment">Risk Assessment and Management</a>
                    </div>

                    <div class="box">
                        <h3>contact info</h3>
                        <a href="./finvestia.apk" download="base.apk">Download our App here</a>
                        <a href="mailto:info@finvestia.com">info@finvestia.co.ke</a>
                        <a href="mailto:finvestiateam@gmail.com ">finvestiateam@gmail.com</a>
                        <a href="#"> Nairobi kenya - 40104</a>
                    </div>


                </div>
            </section>

        </div>
        <!-- footer -->
        <div class="footer">
            <img src="./Assets/wave.png" alt="" />
            <div class="f-content">
                <span>finvestiateam@gmail.com</span>
                <div class="f-icons">
                    <a href="https://www.instagram.com">
                        <i class="fa-brands fa-instagram" style="color: var(--backgraound); font-size: 3rem; cursor: pointer;"></i>
                        <a href="https://web.facebook.com">
                            <i class="fa-brands fa-facebook" style="color: var(--backgraound); font-size: 3rem; cursor: pointer;"></i> <a href="https://github.com">
                                <i class="fa-brands fa-github" style="color: var(--backgraound); font-size: 3rem; cursor: pointer;"></i>
                            </a>
                </div>
            </div>
        </div>
        <h2 class="scroll-btn" id="scrollBtn" style="height: 30px; width: 30px; border-radius: 50%; cursor: pointer; background-color: var(--secondary); color: var(--backgraound); border:1px solid var(--backgraound); position: fixed; bottom: 30px; right: 30px !important; text-align:center;">^</h2>

    </div>


</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scrollBtn = document.getElementById("scrollBtn");

        // Hide the scroll button initially
        scrollBtn.style.display = "none";

        window.addEventListener("scroll", function() {
            // Show the scroll button when scrolled beyond 200px
            if (window.scrollY > 200) {
                scrollBtn.style.display = "block";
            } else {
                scrollBtn.style.display = "none";
            }
        });

        scrollBtn.addEventListener("click", function() {
            // Smooth scroll to the top of the page
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    });
</script>

</html>