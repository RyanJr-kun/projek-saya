@extends('layouts.main')

@section('container')

<div class="container-fluid py-2 ">
      <div class="row">
        <div class="col-12 ">
          <div class="card mb-4 ">
            <div class="card-hrader pb-0 p-3 mb-3">
                <div class="d-lg-flex">
                    <div>
                        <h5 class="mb-0">Data Pengguna</h5>
                            <p class="text-sm mb-0">
                            Kelola data penggunamu
                        </p>
                    </div>
                <div class="ms-auto my-auto mt-lg-0 mt-4">
            <div class="ms-auto my-auto">

        <a href="#Export-Pdf" type="button" class="btn btn-outline-primary me-2 p-2 mb-0" title="PDF" >
            <img src="assets/img/pdf.png" alt="Download PDF" width="20" height="20"></a>
                <a href="#Export-Excel" class="btn btn-outline-primary p-2 me-2 export mb-0 " data-type="csv" type="button" title="Excel">
                    <img src="assets/img/xls.png" alt="Download PDF" width="20" height="20"></a>
                    {{-- triger-modal --}}
                        <button class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#import"><i class="fa fa-plus fixed-plugin-button-nav cursor-pointer pe-2"></i>Add User</button>
                        {{-- s-modal --}}
                        <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog mt-lg-10">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ModalLabel">Buat Pengguna Baru</h5>
                                        <button type="button" class="btn btn-close bg-danger rounded-3 me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                            <div class="modal-body">
    <form>
        <div class="row">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="border-dashed rounded p-3 d-flex justify-content-center align-items-center" style="height: 150px; width: 150px; border-style: dashed; border-width: 2px;">
                    <div class="text-center">
                        <i class="fa fa-circle-plus text-muted fs-4"></i>
                        <p class="mb-0 small">Add Image</p>
                    </div>
                </div>
                <div class="ms-3 text-center">
                    <label for="uploadImage" class="btn btn-outline-primary">Upload Image</label>
                    <input type="file" id="uploadImage" class="d-none">
                    <p class="fw-bold mt-1 small">JPEG, PNG up to 2MB</p>
                </div>
            </div>

            <div class="form-group">
                <div class="mb-3">
                    <label for="userInput" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="userInput" required>
                </div>
                <div class="form-group mb-3">
                    <label for="roleSelect" class="form-label">Role <span class="text-danger">*</span></label>
                    <select class="form-select" id="roleSelect" required>
                        <option selected>Choose...</option>
                        <option value="1">Admin</option>
                        <option value="2">Kasir</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="emailInput" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="emailInput" required>
                </div>
                <div class="form-group">
                    <label for="phoneInput" class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phoneInput" required>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <label for="passwordInput" class="form-label">Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="passwordInput" required>
                    <span class="input-group-text" id="togglePassword"><i class="bi bi-eye-slash"></i></span>
                </div>
            </div>
            <div class="col-md-6">
                <label for="confirmPasswordInput" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmPasswordInput" required>
                    <span class="input-group-text" id="toggleConfirmPassword"><i class="bi bi-eye-slash"></i></span>
                </div>
            </div>
        </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Alamat</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                    <div class="justify-content-end mt-4 form-check form-switch form-check-reverse">
                        <label class="me-auto form-check-label" for="switchCheckReverse">Status</label>
                            <input class="form-check-input text-success" type="checkbox" role="switch" id="switchCheckReverse">
                        </div>
                    </form>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm">Submit</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
         </div>
        {{-- e-modal --}}
      </div>
    </div>
  </div>
</div>
            <div class="card-body px-0 pt-0 pb-2">

              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Posisi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dipekerjakan</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $user["nama"] }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $user["email"] }}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $user["posisi"] }}</p>
                        <p class="text-xs text-secondary mb-0">{{ $user["sub_posisi"] }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm rounded-1 {{ strtolower($user['status']) == 'aktif' ? 'bg-success' : 'bg-danger' }}">{{ $user["status"] }} </span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $user["mulai_kerja"] }}</span>
                      </td>
                      <td class="align-middle">
                        <a href="#" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <i class="fa fa-pen-to-square text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-secondary px-3 font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <i class="fa fa-eye text-dark text-sm opacity-10"></i>
                        </a>
                        <a href="#" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <i class="fa fa-trash text-dark text-sm opacity-10"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
        {{-- <div class="row">
            <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                <h6>Projects table</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Budget</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Completion</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>
                            <div class="d-flex px-2">
                            <div>
                                <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                            </div>
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">Spotify</h6>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">$2,500</p>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">working</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2 text-xs font-weight-bold">60%</span>
                            <div>
                                <div class="progress">
                                <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="d-flex px-2">
                            <div>
                                <img src="../assets/img/small-logos/logo-invision.svg" class="avatar avatar-sm rounded-circle me-2" alt="invision">
                            </div>
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">Invision</h6>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">$5,000</p>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">done</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2 text-xs font-weight-bold">100%</span>
                            <div>
                                <div class="progress">
                                <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="d-flex px-2">
                            <div>
                                <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm rounded-circle me-2" alt="jira">
                            </div>
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">Jira</h6>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">$3,400</p>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">canceled</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2 text-xs font-weight-bold">30%</span>
                            <div>
                                <div class="progress">
                                <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="30" style="width: 30%;"></div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="d-flex px-2">
                            <div>
                                <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm rounded-circle me-2" alt="slack">
                            </div>
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">Slack</h6>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">$1,000</p>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">canceled</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2 text-xs font-weight-bold">0%</span>
                            <div>
                                <div class="progress">
                                <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;"></div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="d-flex px-2">
                            <div>
                                <img src="../assets/img/small-logos/logo-webdev.svg" class="avatar avatar-sm rounded-circle me-2" alt="webdev">
                            </div>
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">Webdev</h6>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">$14,000</p>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">working</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2 text-xs font-weight-bold">80%</span>
                            <div>
                                <div class="progress">
                                <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="80" style="width: 80%;"></div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="d-flex px-2">
                            <div>
                                <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm rounded-circle me-2" alt="xd">
                            </div>
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm">Adobe XD</h6>
                            </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm font-weight-bold mb-0">$2,300</p>
                        </td>
                        <td>
                            <span class="text-xs font-weight-bold">done</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex align-items-center justify-content-center">
                            <span class="me-2 text-xs font-weight-bold">100%</span>
                            <div>
                                <div class="progress">
                                <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                            </button>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div> --}}
      <x-footer></x-footer>
    </div>
@endsection
@section('corejs')
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <style>
  #ofBar {
    background: #fff;
    z-index: 999999999;
    font-size: 16px;
    color: #333;
    padding: 16px 24px;
    font-weight: 400;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 40px;
    width: 80%;
    border-radius: 8px;
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 13px 27px -5px rgba(41,37,36,0.25), 0 8px 16px -8px rgba(41,37,36,0.3), 0 -6px 16px -6px rgba(41,37,36,0.025);
  }

  #ofBar-logo img {
    height: 40px;
  }

  #ofBar-content {
    display: inline;
    padding: 0 15px;
  }

  #ofBar-right {
    display: flex;
    align-items: center;
  }

  #ofBar b {
    font-size: 15px !important;
  }
  #count-down {
    display: initial;
    padding-left: 10px;
    font-weight: bold;
    font-size: 20px;
  }
  #close-bar {
    font-size: 17px;
    opacity: 0.5;
    cursor: pointer;
    color: #808080;
    font-weight: bold;
  }
  #close-bar:hover{
    opacity: 1;
  }
  #btn-bar, .btn-cta-style {
    background: #292524;
    color: #fff;
    border-radius: 4px;
    padding: 10px 20px;
    font-weight: bold;
    text-align: center;
    font-size: 12px;
    opacity: .95;
    margin-right: 20px;
    box-shadow: 0 5px 10px -3px rgba(0,0,0,.23), 0 6px 10px -5px rgba(0,0,0,.25);
  }
   #btn-bar,
   #btn-bar:hover,
   #btn-bar:focus,
   #btn-bar:active,
   .btn-cta-style,
   .btn-cta-style:hover,
   .btn-cta-style:focus,
   .btn-cta-style:active {
     text-decoration: none !important;
     color: #fff !important;
 }
  #btn-bar:hover,
  .btn-cta-style:hover {
    opacity: 1;
  }

  #btn-bar span,
  .btn-cta-style span,
  #ofBar-content span {
    color: red;
    font-weight: 700;
  }
  .btn-cta-style {
    display:inline-block;

  }

  .close-ai-card {
    cursor: pointer;
    font-weight: bold;
    font-size: 20px;
    position: absolute;
    right: 16px;
    top: 16px;
    background: #fff;
    color: #292524;
    width: 32px;
    height: 32px;
    border-radius: 32px;
    opacity: 0.8;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .close-ai-card:hover {
    opacity: 1;
  }

  #oldPriceBar {
    text-decoration: line-through;
    font-size: 16px;
    color: #fff;
    font-weight: 400;
    top: 2px;
    position: relative;
  }
  #newPrice{
    color: #fff;
    font-size: 19px;
    font-weight: 700;
    top: 2px;
    position: relative;
    margin-left: 7px;
  }

  #fromText {
    font-size: 15px;
    color: #fff;
    font-weight: 400;
    margin-right: 3px;
    top: 0px;
    position: relative;
  }

  #pls-contact-me-on-email {
    position: absolute;
    color: white;
    width: 100%;
    height: 100%;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.9);
    z-index: 999;
    cursor: pointer;
    padding-top: 100px;
    padding-left: 50px;
  }

  @media(max-width: 991px){

  }
  @media (max-width: 768px) {
    #count-down {
      display: block;
      margin-top: 15px;
    }

    #ofBar {
      flex-direction: column;
      align-items: normal;
    }

    #ofBar-content {
      margin: 15px 0;
      text-align: center;
      font-size: 18px;
    }

    #ofBar-right {
      justify-content: flex-end;
    }
  }
</style>
@endsection
