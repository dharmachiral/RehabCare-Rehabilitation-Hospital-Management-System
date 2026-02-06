<div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
      <div class="row gx-5">
          <div class="col-lg-6 py-5">
              <div class="py-5">
                  <h1 class="display-5 text-white mb-4">A Trusted Rehabilitation Center for Addiction Recovery</h1>
                  <p class="text-white mb-0">hospital Drugs and Alcohol Treatment Center in अतरिया-१, कैलाली provides compassionate, professional care to help individuals overcome addiction. Our certified specialists use evidence-based therapies to create personalized treatment plans for lasting recovery. We're committed to supporting you through every step of your journey to wellness.</p>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
                  <h1 class="text-white mb-4">Request a Consultation</h1>
                  <form action="{{ route('appoitment.store') }}" method="POST">
                      @csrf
                      <div class="row g-3">
                          <div class="col-12 col-sm-6">
                              <input type="text" class="form-control bg-light border-0" name="name" placeholder="Your Name" style="height: 55px;">
                          </div>
                          <div class="col-12 col-sm-6">
                              <input type="tel" class="form-control bg-light border-0" name="contact" placeholder="Your contact" style="height: 55px;">
                          </div>
                          <div class="col-12 col-sm-6">
                            <input type="text" class="form-control bg-light border-0" name="email" placeholder="Your Email" style="height: 55px;">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="tel" class="form-control bg-light border-0" name="subject" placeholder="Subject" style="height: 55px;">
                        </div>
                          <div class="col-12 col-sm-6">
                              <div class="date" id="date1" data-target-input="nearest">
                                  <input type="text"
                                      class="form-control bg-light border-0 datetimepicker-input"
                                      placeholder="Preferred Date" data-target="#date1" data-toggle="datetimepicker" name="preferred_date" style="height: 55px;">
                              </div>
                          </div>
                          <div class="col-12 col-sm-6">
                              <div class="time" id="time1" data-target-input="nearest">
                                  <input type="text"
                                      class="form-control bg-light border-0 datetimepicker-input"
                                      placeholder="Preferred Time" data-target="#time1" data-toggle="datetimepicker" name="preferred_time" style="height: 55px;">
                              </div>
                          </div>
                          <div class="col-12">
                            <textarea class="form-control border-0 bg-light px-4 py-3" rows="5" name="message" placeholder="Message"></textarea>
                        </div>
                          <div class="col-12">
                              <button class="btn btn-dark w-100 py-3" type="submit">Get Help Now</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>