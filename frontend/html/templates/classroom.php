<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS (to be included) -->
    

    <title>LRLMS ClassRoom</title>
</head>

<body>

    <!-- RIGHT SIDEBAR -->
    <div class="collapse" id="lrlms-class-room-sidebar">
        <nav class="navbar lrlms-sidebar-top-nav">
            <div class="lrlms-class-room-sidebar-toggler">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lrlms-class-room-sidebar" aria-controls="lrlms-class-room-sidebar"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <img src="../images/bars.svg" alt="">
                </button>
            </div>

            <div class="lrms-class-room-sidebar-title nav justify-content-center">{CourseName}</div>
            <div class="lrlms-class-room-sidebar-profile"><a href="#/"><img src="../images/user-icon.svg" alt=""></a></div>

        </nav>
        <div class="lrlms-sidebar-topinfo">
            <div>
                <span><b>ClassRoom:</b></span>
                <p>{ClassRoom-Name}</p>
            </div>
            <div>
                <span><b>Teacher:</b></span>
                <p>{Teacher-Name}</p>
            </div>
        </div>
        <div class="lrlms-sidebar-nav-lessons">
            <a class="lrlms-lessons-toggler d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#lrlms-nav-wrap" aria-expanded="false" aria-controls="lrlms-nav-wrap">
                Lessons
                <span class=""><img src="../images/angle-down.svg" alt=""></span>
            </a>
            <div class="collapse" id="lrlms-nav-wrap">
                <ul class="list-group lrlms-lesson-list">
                    <a href="#/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lrlms-lesson lrlms-lesson-unlock"><span><img src="../images/check-circle.svg" alt=""></span><div class="lrlms-lesson-text">Lesson1</div>
                        <span class="badge badge-pill">1:45</span>
                    </a>
                    <a href="#/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lrlms-lesson"><span><img src="../images/lock.svg" alt=""></span>
                        <div class="lrlms-lesson-text">Lesson2</div>
                        <span class="badge badge-pill">2:00</span>
                    </a>
                    <a href="#/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lrlms-lesson"><span><img src="../images/lock.svg" alt=""></span>
                        <div class="lrlms-lesson-text">Lesson3</div>
                        <span class="badge badge-pill">1:30</span>
                    </a>
                    <a href="#/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lrlms-lesson"><span><img src="../images/lock.svg" alt=""></span>
                        <div class="lrlms-lesson-text">Lesson4</div>
                        <span class="badge badge-pill">1:30</span>
                    </a>
                    <a href="#/" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center lrlms-lesson"><span><img src="../images/lock.svg" alt=""></span>
                        <div class="lrlms-lesson-text">Lesson5</div>
                        <span class="badge badge-pill">1:30</span>
                    </a>
                </ul>
            </div>
        </div>

        <div class="lrlms-sidebar-chat-members">
                <a class="lrlms-chat-toggler d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#lrlms-chat-wrap" aria-expanded="false" aria-controls="lrlms-chat-wrap">
                    ClassRoom
                    <span class=""><img src="../images/angle-down.svg" alt=""></span>
                </a>
                <div class="collapse" id="lrlms-chat-wrap">
                        <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Live Chat</a>
                                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Members</a>
                                </div>
                              </nav>
                              <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    How can I center a imgage in css?
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse magni vero tempora possimus fugiat officia doloremque expedita commodi quidem blanditiis impedit obcaecati unde nihil eveniet voluptatem culpa, provident dicta distinctio?
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                              </div>

                </div> 
        </div>
    </div>
    <!-- TOP NAV -->
    <nav class="navbar navbar-light bg-light sticky-top">
        <div class="float-right lrlms-class-room-back"><a href="#/"><img src="../images/arrow-left.svg" alt=""></a></div>
        <div class="lrms-class-room-nav-title nav justify-content-center">{ClassRoom}-{CourseName}</div>
        <div class="lrlms-class-room-sidebar-toggler">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lrlms-class-room-sidebar" aria-controls="lrlms-class-room-sidebar"
                aria-expanded="false" aria-label="Toggle navigation">
                <img src="../images/bars.svg" alt="">
            </button>
        </div>
    </nav>

    <!-- CONTENT -->
    <section id="lrlms-lesson-content">
        <!-- IF FULL width
        <div class="container-fluid"> -->
        
        <!-- IF centered -->
        <div class="container">
            <h1>Lorem ipsum dolor sit amet</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed placeat odio at incidunt dignissimos voluptate animi, molestias sit labore fugiat magnam illum, dolor amet culpa ipsum, sapiente iusto odit reiciendis?</p>
            <p>Adipisci delectus in, earum minima iste architecto odit enim cupiditate alias perferendis itaque sequi quis et corrupti ipsam labore consequuntur odio porro omnis obcaecati a? Est minima dolorum deserunt animi!</p>
            <p>Enim culpa voluptate unde natus id consectetur distinctio, nisi recusandae nulla eveniet. Deleniti molestiae inventore praesentium qui asperiores optio labore illum delectus, vel, veritatis, dolore necessitatibus unde? Odio, esse vel!</p>
            <p>Fugit officia veritatis error aliquam praesentium distinctio, provident totam est ipsam animi. Delectus quos quas possimus maiores eos officiis nam architecto voluptas nostrum placeat, doloremque aliquam, corporis, repellat pariatur laboriosam?</p>
            <p>Minima, et ullam. Eius reiciendis in suscipit culpa dolore illo sapiente, numquam repellat atque aut dolorem ab eveniet minus, molestias non sed, aliquid saepe ratione? Assumenda laboriosam rerum totam animi.</p>
            <hr>
            <h2>Lorem ipsum</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed placeat odio at incidunt dignissimos voluptate animi, molestias sit labore fugiat magnam illum, dolor amet culpa ipsum, sapiente iusto odit reiciendis?</p>
            <p>Adipisci delectus in, earum minima iste architecto odit enim cupiditate alias perferendis itaque sequi quis et corrupti ipsam labore consequuntur odio porro omnis obcaecati a? Est minima dolorum deserunt animi!</p>
            <p>Enim culpa voluptate unde natus id consectetur distinctio, nisi recusandae nulla eveniet. Deleniti molestiae inventore praesentium qui asperiores optio labore illum delectus, vel, veritatis, dolore necessitatibus unde? Odio, esse vel!</p>
            <p>Fugit officia veritatis error aliquam praesentium distinctio, provident totam est ipsam animi. Delectus quos quas possimus maiores eos officiis nam architecto voluptas nostrum placeat, doloremque aliquam, corporis, repellat pariatur laboriosam?</p>
            <p>Minima, et ullam. Eius reiciendis in suscipit culpa dolore illo sapiente, numquam repellat atque aut dolorem ab eveniet minus, molestias non sed, aliquid saepe ratione? Assumenda laboriosam rerum totam animi.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed placeat odio at incidunt dignissimos voluptate animi, molestias sit labore fugiat magnam illum, dolor amet culpa ipsum, sapiente iusto odit reiciendis?</p>
            <p>Adipisci delectus in, earum minima iste architecto odit enim cupiditate alias perferendis itaque sequi quis et corrupti ipsam labore consequuntur odio porro omnis obcaecati a? Est minima dolorum deserunt animi!</p>
            <p>Enim culpa voluptate unde natus id consectetur distinctio, nisi recusandae nulla eveniet. Deleniti molestiae inventore praesentium qui asperiores optio labore illum delectus, vel, veritatis, dolore necessitatibus unde? Odio, esse vel!</p>
            <p>Fugit officia veritatis error aliquam praesentium distinctio, provident totam est ipsam animi. Delectus quos quas possimus maiores eos officiis nam architecto voluptas nostrum placeat, doloremque aliquam, corporis, repellat pariatur laboriosam?</p>
            <p>Minima, et ullam. Eius reiciendis in suscipit culpa dolore illo sapiente, numquam repellat atque aut dolorem ab eveniet minus, molestias non sed, aliquid saepe ratione? Assumenda laboriosam rerum totam animi.</p>
        </div>
    </section>

    <!-- JavaScript files, to be added -->

</body>

</html>