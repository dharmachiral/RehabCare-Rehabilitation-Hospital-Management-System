<div class="wrapper pb-0">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card text-center bg-primary">
                    <div class="icon box">
                        <img src="/images/recovered.png" alt="recovered-img" class="img-fluid rounded-circle mb-3"
                            width="100px">
                    </div>
                    <div>
                        <h4 class="text-white">Personalized Recovery Programs</h4>
                        <div class="text-container">
                            <p class="text-white truncated">{!! strip_tags($data['profile']->mission) !!}</p>
                            <button class="read-more-btn btn btn-sm btn-light mt-2 d-none">Read More</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card text-center h-100 bg-primary">
                    <div class="icon box">
                        <img src="/images/customer.png" alt="customer=img" class="img-fluid rounded-circle mb-3"
                            width="100px">
                    </div>
                    <div>
                        <h4 class="text-white">24/7 Support & Care</h4>
                        <div class="text-container">
                            <p class="text-white truncated">{!! strip_tags($data['profile']->vision) !!}</p>
                            <button class="read-more-btn btn btn-sm btn-light mt-2 d-none">Read More</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card text-center h-100 bg-primary">
                    <div class="icon box">
                        <img src="/images/holistic-health.png" alt="holistic-health-img"
                            class="img-fluid rounded-circle mb-3" width="100px">
                    </div>
                    <div>
                        <h4 class="text-white">Holistic Healing Approach</h4>
                        <div class="text-container">
                            <p class="text-white truncated">{!! strip_tags($data['profile']->footer_text) !!}</p>
                            <button class="read-more-btn btn btn-sm btn-light mt-2 d-none">Read More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying full text -->
<div class="modal fade" id="textModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
