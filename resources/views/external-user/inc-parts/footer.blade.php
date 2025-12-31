  <!-- section end for featured brands -->

  <!-- start of footer section -->
  <section class="container-fluid px-0 mx-0">
      <div class="card mx-0 py-4 pt-0 px-3 px-md-5 rounded-0">
          <div class="row py-2 pt-1">
              <div class="col-md-3 mt-3 footer_menu">
                  <h5 class="text-every fs-5 fw-bold">Information</h5>
                  <ul>
                      <li><a href="{{ route('home') }}">Home</a></li>
                      <li><a href="{{ route('privacyAndPolicy') }}">Privacy Policy</a></li>
                      <li><a href="{{ route('dataProtection') }}">Data Protection</a></li>
                      <li><a href="{{ route('imprint') }}">Imprint</a></li>
                      <li><a href="{{ route('termsAndCondition') }}">Terms & Conditions</a></li>
                  </ul>
              </div>
              <div class="col-md-3 mt-3 footer_menu">
                  <h5 class="text-every fs-5 fw-bold">Customer Service </h5>
                  <ul>
                      <li><a href="{{ route('help.community') }}">Help & Support</a></li>
                      <li><a href="{{ route('help.community') }}">Support</a></li>

                  </ul>
              </div>
              <div class="col-md-3 mt-3 footer_menu">
                  <h5 class="text-every fs-5 fw-bold">Buy on WBG24.com</h5>
                  <ul>
                      <li><a href="{{ route('all.products') }}">Buy Product</a></li>
                      <li><a href="{{ route('all.tenders') }}">Buy Tenders</a></li>
                      <li><a href="{{ route('benefits.buyers') }}">Get Quote</a></li>
                      <li><a href="{{ route('howToBuy') }}">How to Buy</a></li>
                  </ul>
              </div>
              <div class="col-md-3 mt-3 footer_menu">
                  <h5 class="text-every fs-5 fw-bold">Sell on WBG24.com</h5>
                  <ul>
                      <li><a
                              href="{{ isset(auth()->user()->account_type) && auth()->user()->account_type == 'seller' ? route('seller.add.product') : route('user.member.package') }}">Upload
                              Product</a></li>
                      <li><a
                              href="{{ isset(auth()->user()->account_type) && auth()->user()->account_type == 'seller' ? route('seller.add.tender') : route('user.member.package') }}">Upload
                              Tender</a></li>
                      <li><a href="{{ route('user.source-pro') }}">Send Quote</a></li>

                      <li><a href="{{ route('howToSell') }}">How to Sell</a></li>
                  </ul>
              </div>
          </div>
      </div>
      <div class="row justify-content-center" style="border-top: 1px solid #ddd">
          <div class="col-md-11">
              <div class="footer_sec pt-4">
                  @foreach ($footerCategories as $category)
                      <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }} | </a>
                  @endforeach
              </div>
              <hr />
              <!--<div class="footer_sec py-3 pt-1">
                  <a href="">Advertisements With Us</a> | <a href=""> Job</a> |
                  <a href="">Franchisee</a>
              </div>-->
          </div>
      </div>
  </section>

  <!-- last footer -->
  <footer class="container-fluid px-0">
      <div class="row py-2 px-4">
          <div class="col-md-3"></div>
          <div class="col-md-6 text-center">
              <a href="http://wbg24.com">
                  <!-- write copyright message here -->
                  Copyright &copy; {{ date('Y') }} World Business Guide - www.wbg24.com . All Rights Reserved
              </a>
          </div>
          <div class="col-md-3 text-md-end text-center">
              <a href="https://www.facebook.com/wbg24/" class="fs-5 text-primary me-2"><i class="fa-brands fa-square-facebook"></i></a>
              <a href="https://www.instagram.com/worldbusinessguideofficial/" class="fs-5 text-primary"><i class="fa-brands fa-square-instagram"></i></a>
          </div>
      </div>
  </footer>
  <!-- end of footer -->
  <script>
      @if (Session::has('message'))

          var type = "{{ Session::get('alert-type', 'info') }}";



          switch (type) {
              case 'info':
                  toastr.info(" {{ Session::get('message') }} ");
                  break;

              case 'success':
                  Swal.fire({
                      title: "<h5 class='fw-bolder fs-5'>Congratulation!</h5>",
                      text: "{{ Session::get('message') }}",
                      icon: "success",
                      draggable: true,
                      confirmButtonText: "Okay",
                      confirmButtonColor: "#FF7519",
                  })
                  break;

              case 'warning':
                  toastr.warning(" {{ Session::get('message') }} ");
                  break;

              case 'error':
                  toastr.error(" {{ Session::get('message') }} ");
                  break;
              case 'unauth':
                  Swal.fire({
                      title: "<h5 class='fw-bolder fs-5'>To use this option you need to</h5>",
                      text: "",
                      icon: "",
                      draggable: true,
                      confirmButtonText: "Sign in",
                      confirmButtonColor: "#FF7519",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          location.href = "{{ route('login') }}";
                      }
                  });
                  break;
          }
      @endif
  </script>


  <script src="https://translate.google.com/translate_a/element.js?cb=customGoogleTranslateInit"></script>
  <script>
      function customGoogleTranslateInit() {
          new google.translate.TranslateElement({
              pageLanguage: 'en'
          }, 'customGoogleTranslateElement');
      }
      const customLanguages = {
          "af": {
              name: "Afrikaans",
              flag: "za"
          },
          "sq": {
              name: "Albanian",
              flag: "al"
          },
          "am": {
              name: "Amharic",
              flag: "et"
          },
          "ar": {
              name: "Arabic",
              flag: "sa"
          },
          "hy": {
              name: "Armenian",
              flag: "am"
          },
          "az": {
              name: "Azerbaijani",
              flag: "az"
          },
          "eu": {
              name: "Basque",
              flag: "es"
          },
          "be": {
              name: "Belarusian",
              flag: "by"
          },
          "bn": {
              name: "Bengali",
              flag: "bd"
          },
          "bs": {
              name: "Bosnian",
              flag: "ba"
          },
          "bg": {
              name: "Bulgarian",
              flag: "bg"
          },
          "ca": {
              name: "Catalan",
              flag: "es"
          },
          "ceb": {
              name: "Cebuano",
              flag: "ph"
          },
          "zh-CN": {
              name: "Chinese (Simplified)",
              flag: "cn"
          },
          "zh-TW": {
              name: "Chinese (Traditional)",
              flag: "tw"
          },
          "co": {
              name: "Corsican",
              flag: "fr"
          },
          "hr": {
              name: "Croatian",
              flag: "hr"
          },
          "cs": {
              name: "Czech",
              flag: "cz"
          },
          "da": {
              name: "Danish",
              flag: "dk"
          },
          "nl": {
              name: "Dutch",
              flag: "nl"
          },
          "en": {
              name: "English",
              flag: "us"
          },
          "eo": {
              name: "Esperanto",
              flag: "eu"
          },
          "et": {
              name: "Estonian",
              flag: "ee"
          },
          "fi": {
              name: "Finnish",
              flag: "fi"
          },
          "fr": {
              name: "French",
              flag: "fr"
          },
          "fy": {
              name: "Frisian",
              flag: "nl"
          },
          "gl": {
              name: "Galician",
              flag: "es"
          },
          "ka": {
              name: "Georgian",
              flag: "ge"
          },
          "de": {
              name: "German",
              flag: "de"
          },
          "el": {
              name: "Greek",
              flag: "gr"
          },
          "gu": {
              name: "Gujarati",
              flag: "in"
          },
          "ht": {
              name: "Haitian Creole",
              flag: "ht"
          },
          "ha": {
              name: "Hausa",
              flag: "ng"
          },
          "haw": {
              name: "Hawaiian",
              flag: "us"
          },
          "he": {
              name: "Hebrew",
              flag: "il"
          },
          "hi": {
              name: "Hindi",
              flag: "in"
          },
          "hmn": {
              name: "Hmong",
              flag: "cn"
          },
          "hu": {
              name: "Hungarian",
              flag: "hu"
          },
          "is": {
              name: "Icelandic",
              flag: "is"
          },
          "ig": {
              name: "Igbo",
              flag: "ng"
          },
          "id": {
              name: "Indonesian",
              flag: "id"
          },
          "ga": {
              name: "Irish",
              flag: "ie"
          },
          "it": {
              name: "Italian",
              flag: "it"
          },
          "ja": {
              name: "Japanese",
              flag: "jp"
          },
          "jv": {
              name: "Javanese",
              flag: "id"
          },
          "kn": {
              name: "Kannada",
              flag: "in"
          },
          "kk": {
              name: "Kazakh",
              flag: "kz"
          },
          "km": {
              name: "Khmer",
              flag: "kh"
          },
          "rw": {
              name: "Kinyarwanda",
              flag: "rw"
          },
          "ko": {
              name: "Korean",
              flag: "kr"
          },
          "ku": {
              name: "Kurdish (Kurmanji)",
              flag: "iq"
          },
          "ky": {
              name: "Kyrgyz",
              flag: "kg"
          },
          "lo": {
              name: "Lao",
              flag: "la"
          },
          "la": {
              name: "Latin",
              flag: "va"
          },
          "lv": {
              name: "Latvian",
              flag: "lv"
          },
          "lt": {
              name: "Lithuanian",
              flag: "lt"
          },
          "lb": {
              name: "Luxembourgish",
              flag: "lu"
          },
          "mk": {
              name: "Macedonian",
              flag: "mk"
          },
          "mg": {
              name: "Malagasy",
              flag: "mg"
          },
          "ms": {
              name: "Malay",
              flag: "my"
          },
          "ml": {
              name: "Malayalam",
              flag: "in"
          },
          "mt": {
              name: "Maltese",
              flag: "mt"
          },
          "mi": {
              name: "Maori",
              flag: "nz"
          },
          "mr": {
              name: "Marathi",
              flag: "in"
          },
          "mn": {
              name: "Mongolian",
              flag: "mn"
          },
          "my": {
              name: "Myanmar (Burmese)",
              flag: "mm"
          },
          "ne": {
              name: "Nepali",
              flag: "np"
          },
          "no": {
              name: "Norwegian",
              flag: "no"
          },
          "ny": {
              name: "Nyanja (Chichewa)",
              flag: "mw"
          },
          "or": {
              name: "Odia (Oriya)",
              flag: "in"
          },
          "ps": {
              name: "Pashto",
              flag: "af"
          },
          "fa": {
              name: "Persian",
              flag: "ir"
          },
          "pl": {
              name: "Polish",
              flag: "pl"
          },
          "pt": {
              name: "Portuguese",
              flag: "pt"
          },
          "pa": {
              name: "Punjabi",
              flag: "in"
          },
          "ro": {
              name: "Romanian",
              flag: "ro"
          },
          "ru": {
              name: "Russian",
              flag: "ru"
          },
          "sm": {
              name: "Samoan",
              flag: "ws"
          },
          "gd": {
              name: "Scots Gaelic",
              flag: "gb"
          },
          "sr": {
              name: "Serbian",
              flag: "rs"
          },
          "st": {
              name: "Sesotho",
              flag: "ls"
          },
          "sn": {
              name: "Shona",
              flag: "zw"
          },
          "sd": {
              name: "Sindhi",
              flag: "pk"
          },
          "si": {
              name: "Sinhala",
              flag: "lk"
          },
          "sk": {
              name: "Slovak",
              flag: "sk"
          },
          "sl": {
              name: "Slovenian",
              flag: "si"
          },
          "so": {
              name: "Somali",
              flag: "so"
          },
          "es": {
              name: "Spanish",
              flag: "es"
          },
          "su": {
              name: "Sundanese",
              flag: "id"
          },
          "sw": {
              name: "Swahili",
              flag: "ke"
          },
          "sv": {
              name: "Swedish",
              flag: "se"
          },
          "tl": {
              name: "Tagalog (Filipino)",
              flag: "ph"
          },
          "tg": {
              name: "Tajik",
              flag: "tj"
          },
          "ta": {
              name: "Tamil",
              flag: "lk"
          },
          "tt": {
              name: "Tatar",
              flag: "ru"
          },
          "te": {
              name: "Telugu",
              flag: "in"
          },
          "th": {
              name: "Thai",
              flag: "th"
          },
          "tr": {
              name: "Turkish",
              flag: "tr"
          },
          "tk": {
              name: "Turkmen",
              flag: "tm"
          },
          "uk": {
              name: "Ukrainian",
              flag: "ua"
          },
          "ur": {
              name: "Urdu",
              flag: "pk"
          },
          "ug": {
              name: "Uyghur",
              flag: "cn"
          },
          "uz": {
              name: "Uzbek",
              flag: "uz"
          },
          "vi": {
              name: "Vietnamese",
              flag: "vn"
          },
          "cy": {
              name: "Welsh",
              flag: "gb"
          },
          "xh": {
              name: "Xhosa",
              flag: "za"
          },
          "yi": {
              name: "Yiddish",
              flag: "il"
          },
          "yo": {
              name: "Yoruba",
              flag: "ng"
          },
          "zu": {
              name: "Zulu",
              flag: "za"
          }
      };

      const customLanguageList = document.getElementById("customLanguageList");
      let languagesArray = Object.keys(customLanguages);
      languagesArray.forEach((code, index) => {
          const div = document.createElement("div");
          div.classList.add("col-md-6");
          div.innerHTML = `
            <div class="custom-language-item" data-lang="${code}">
                <img src="https://flagcdn.com/w40/${customLanguages[code].flag}.png" alt="Flag"> 
                ${customLanguages[code].name}
            </div>`;
          customLanguageList.appendChild(div);
      });

      function customUpdateLanguage(lang) {
          let selectField = document.querySelector('.goog-te-combo');
          if (selectField) {
              selectField.value = lang;
              selectField.dispatchEvent(new Event('change'));
          }

          localStorage.setItem("selectedLanguage", lang);

          document.querySelectorAll(".custom-language-item").forEach(item => item.classList.remove(
              "custom-language-selected"));
          let selectedItem = document.querySelector(`[data-lang="${lang}"]`);
          selectedItem.classList.add("custom-language-selected");

          document.getElementById("customSelectedLanguage").innerText = customLanguages[lang].name;
          document.getElementById("customSelectedFlag").src = `https://flagcdn.com/w40/${customLanguages[lang].flag}.png`;
      }

      function customRestoreLanguage() {
          let savedLang = localStorage.getItem("selectedLanguage") || "en";
          customUpdateLanguage(savedLang);
      }
      document.getElementById("customLanguageList").addEventListener("click", function(event) {
          if (event.target.closest(".custom-language-item")) {
              let lang = event.target.closest(".custom-language-item").getAttribute("data-lang");
              customUpdateLanguage(lang);
          }
      });
      window.onload = customRestoreLanguage;
  </script>
