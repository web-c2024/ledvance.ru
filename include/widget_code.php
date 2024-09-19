<div id="AsproForm">
    <div class="tab">
        <label class="form__label-cloud" required>Выберите тип услуги: </label>
        <div>
            <div class="form_radio">
                <input type="radio" id="contactChoice1"
                       name="service" value="1"
                       class="radio_option"
                       data-radio-calc
                       checked>
                <label for="contactChoice1">Отопление</label>
            </div>
        </div>

        <div>
            <div class="form_radio">
                <input type="radio" id="contactChoice2"
                       name="service" value="2"
                       class="radio_option"
                       data-radio-calc
                >
                <label for="contactChoice2">Водоснабжение и канализация</label>
            </div>
        </div>

        <div>
            <div class="form_radio">
                <input type="radio" id="contactChoice3"
                       name="service" value="3"
                       class="radio_option"
                       data-radio-calc
                >
                <label for="contactChoice3">Теплый пол</label>
            </div>
        </div>
    </div>

    <div class="tab">
        <div class="tab-content heating active-tab" data-tab-1>
            <div class="content_input">
                <label class="form__label-cloud" required>Укажите площадь помещения</label>
                <div class="form_radio">
                    <input type="radio" id="Area"
                           name="area" value="1"
                           class="room_area"
                           checked
                    >
                    <label for="Area">До 150 кв.м</label>
                </div>

                <div class="form_radio">
                    <div class="form_radio">
                        <input type="radio" id="Area2"
                               name="area" value="2"
                               class="radio_option"
                        >
                        <label for="Area2">От 150 кв.м. до 350 кв.м</label>
                    </div>
                </div>
            </div>

            <div class="content_input">
                <label class="form__label-cloud" required for="name">Укажите количество окон в доме</label>
                <div>
                    <input class="form__control-cloud" type="text" id="name" name="window">
                </div>
            </div>

            <label class="form__label-cloud" required>Выберите вариант системы</label>
            <div class="form_radio">
                <input type="radio" id="systemVariant"
                       name="system" value="1"
                       class="system_variant"
                       checked>
                <label for="systemVariant">Стандарт</label>
            </div>

            <div class="form_radio">
                <input type="radio" id="systemVariant2"
                       name="system" value="2"
                       class="system_variant">
                <label for="systemVariant2">Комфорт</label>
            </div>

            <div class="form_radio">
                <input type="radio" id="systemVariant3"
                       name="system" value="3"
                       class="system_variant">
                <label for="systemVariant3">Премиум</label>
            </div>
        </div>
        <div class="tab-content water_sewerage" data-tab-2>
            <div class="content_input">
                <label class="form__label-cloud">Укажите площадь помещения</label>
                <div class="form_radio">
                    <input type="radio" id="AreaTab"
                           name="area_test" value="1"
                           class="room_area"
                           checked
                    >
                    <label for="AreaTab">До 150 кв.м</label>
                </div>

                <div class="form_radio">
                    <input type="radio" id="AreaTab2"
                           name="area_test" value="2"
                           class="radio_option"
                    >
                    <label for="AreaTab2">От 150 кв.м. до 350 кв.м</label>
                </div>
            </div>

            <div class="content_input">
                <label class="form__label-cloud" required for="name">Укажите количество сантехнических приборов, включая кухонную мойку и стиральную машину</label>
                <div>
                    <input class="form__control-cloud input-text" type="text" name="technique" required="required">
                </div>
            </div>

            <label class="form__label-cloud">Выберите вариант системы</label>
            <div class="form_radio">
                <input type="radio" id="systemVariantTab"
                       name="var_system" value="1"
                       class="system_variant"
                       checked
                >
                <label for="systemVariantTab">Стандарт</label>
            </div>

            <div class="form_radio">
                <input type="radio" id="systemVariantTab2"
                       name="var_system" value="2"
                       class="system_variant">
                <label for="systemVariantTab2">Комфорт</label>
            </div>

            <div class="form_radio">
                <input type="radio" id="systemVariantTab3"
                       name="var_system" value="3"
                       class="system_variant">
                <label for="systemVariantTab3">Премиум</label>
            </div>
        </div>
        <div class="tab-content warm_floor" data-tab-3>
            <div>
                <label class="form__label-cloud" required for="name">Укажите площадь теплого пола</label>
                <div>
                    <input class="form__control-cloud" type="text" id="name" name="floor-area" size="10">
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <p>Наш менеджер рассчитает стоимость работ и отправит удобным вам способом. Пожалуйста, укажите ваши контактные данные для связи.</p>
        <div class="content_input">
            <label class="form__label-cloud" required for="name">Имя</label>
            <div>
                <input class="form__control-cloud" required type="text" id="name" name="name" size="10">
            </div>
        </div>
        <div class="content_input">
            <label class="form__label-cloud" required for="phone">Телефон</label>
            <div>
                <input class="form__control-cloud" required type="text" id="phone" name="phone" size="10">
            </div>
        </div>
        <div class="content_input">
            <label class="form__label-cloud" for="email">Email</label>
            <div>
                <input class="form__control-cloud" type="text" id="email" name="email" size="10">
            </div>
        </div>
        <div class="content_input">
            <label class="form__label-cloud" for="comment">Комментарий</label>
            <div>
                <input class="form__control-cloud" type="text" id="comment" name="comment" size="10">
            </div>
        </div>
    </div>
    <div class="tab tab-finish">
        <p class="finish-form">Cпасибо!</p>
        <p>Ваше сообщение отправлено</p>
    </div>
    <div style="overflow:auto;">
        <div style="float:right; margin-top: 20px;">
            <button class="btn1 green-cloud" type="button" id="prevBtn" onclick="nextPrev(-1)">Назад</button>
            <button class="btn1 btn-primary-cloud" type="button" id="nextBtn" onclick="nextPrev(1)">Далее</button>
        </div>
    </div>
    <div style="display:none; text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</div>

<style>
    #AsproForm {
        background-color: var(--light, #ffffff) var(--dark, #232323);
        max-width: 500px;
        min-width: 300px;
    }

    body #AsproForm .form__control-cloud{
        border: 1px solid var(--light, transparent) var(--dark, #e5e5e5);;
        background-color: var(--light, #F3F4F9) var(--dark, #121212);
        color: var(--light, black) var(--dark, white);
        border-radius: 5px;
        height: 40px;
        padding: 9px 14px;
        transition: background-color 0.2s, border-color 0.2s;
        outline: none;
        width: 100%;
    }

    body #AsproForm .form__control-cloud:focus {
        background-color: var(--light, #fff) var(--dark, #2a2a2a);
        border: 1px solid #97A3B0 !important;
    }

    #AsproForm .form_radio label:before {
        content: "";
        display: inline-block;
        width: 20px;
        height: 20px;
        position: absolute;
        left: 0;
        top: 2px;
        bottom: 1px;
        background: #fff;
        border: 1px solid #E6E9F2;
        border: 1px solid var(--light, #E6E9F2) var(--dark, transparent);
        border-radius: 10px;
    }

    #AsproForm .form__label-cloud {
        font-weight: 500;
        font-size: 14px;
        line-height: 18px;
        color: var(--light, #333) var(--dark, #ffffff);
        margin-bottom: 10px;
    }

    #AsproForm .finish-form {
        font-size: 20px;
        font-weight: 500;
    }
    #AsproForm .send_form {
        display: none !important;
    }

    #AsproForm .form_radio {
        margin-bottom: 10px;
        height: 20px;
    }
    #AsproForm .form_radio input[type=radio] {
        display: none;
    }

    #AsproForm .form_radio label {
        display: inline-block;
        cursor: pointer;
        position: relative;
        padding-left: 30px;
        margin-right: 0;
        user-select: none;
    }

    #AsproForm .form_radio label:after {
        content: "";
        display: none;
        width: 8px;
        height: 8px;
        position: absolute;
        left: 6px;
        bottom: 1px;
        background: #fff;
        border: 1px solid #1C4ADE;
        border-radius: 10px;
        top: 8px;
    }

    #AsproForm .form_radio input[type=radio]:checked + label:before {
        background: #1C4ADE 0 0 no-repeat;
    }

    #AsproForm .form_radio input[type=radio]:checked + label:after {
        display: inline-block;
    }

    #AsproForm input[type=radio] {
        display: none;
    }

    #AsproForm .content_input {
        margin-bottom: 20px;
    }

    #AsproForm .input-text {
        padding: 0;
    }

    #AsproForm .heating {
        display: block;
    }

    #AsproForm .water_sewerage {
        display: none;
    }

    #AsproForm .warm_floor {
        display: none;
    }

    #AsproForm input {
        padding: 10px;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        border: 1px solid #aaaaaa;
    }

    body #AsproForm .error-cloud {
        border: 1px solid #FF7188 !important;
    }

    #AsproForm .tab {
        display: none;
    }

    #AsproForm .form__label-cloud[required]:after {
        content: '*';
        color: red;
        margin-left: 4px;
    }

    #AsproForm .btn1 {
        font-size: 13px;
        font-weight: 500;
        text-transform: none;
        padding: 9px 16px !important;
        box-shadow: none !important;
        letter-spacing: normal;
        height: 36px;
        display: inline-flex;
        align-items: center;
        text-align: center;
        vertical-align: middle;
        touch-action: manipulation;
        cursor: pointer;
        background-image: none;
        border: 1px solid transparent;
        white-space: nowrap;
        border-radius: 5px;
    }

    #AsproForm .btn-primary-cloud {
        background-color: #1C4ADE !important;
        border-color: #1C4ADE !important;
        color: #fff;
    }

    #AsproForm .green-cloud {
        color: #fff;
        background-color: #91A2B6;;
        border-color: #91A2B6;
        margin-right: 5px;
    }
</style>

<script>
    var radioElements = document.querySelectorAll('#AsproForm input[data-radio-calc]');
    var tabsContent = document.querySelectorAll('#AsproForm .tab-content');
    var currentTab = 0;

    radioElements.forEach(function(el) {
        el.addEventListener('change', function(e) {
            showTabBlock(e.target.value);
        })
    });

    function showTabBlock(numBlock) {
        tabsContent.forEach(function(el) {
            el.style.display = 'none';
            el.classList.remove("active-tab");
        })
        tabsContent[numBlock - 1].style.display = 'block';
        tabsContent[numBlock - 1].classList.add("active-tab");
    }

    showTab(currentTab);

    function showTab(n) {
        var tabs = document.getElementsByClassName("tab");
        tabs[n].style.display = "block";
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline-flex";
        }
        if (n == 2) {
            document.getElementById("nextBtn").innerHTML = "Отправить";
        } else {
            document.getElementById("nextBtn").innerHTML = "Далее";
        }

        if (n == 3) {
            document.getElementById("prevBtn").style.display = "none";
            document.getElementById("nextBtn").style.display = "none";
        }
    }

    function nextPrev(n) {
        if (n == 1) {
            var inputsFilled = true;
            if (currentTab == 1) {
                var inputs = document.querySelector("#AsproForm .active-tab").getElementsByTagName("input");;
                for (i = 0; i < inputs.length; i++) {
                    if (inputs[i].value == "") {
                        inputs[i].className += " error-cloud";
                        inputsFilled = false;
                    }
                }
            }
            if (currentTab == 2) {
                var inputs = document.querySelectorAll("#AsproForm .active-form-tab [required]");
                for (i = 0; i < inputs.length; i++) {
                    if (inputs[i].value == "") {
                        inputs[i].className += " error-cloud";
                        inputsFilled = false;
                    }
                }
            }
            if (!inputsFilled)  return false;
        }
        var tabs = document.getElementsByClassName("tab");
        if (!validateForm()) return false;
        tabs[currentTab].style.display = "none";
        tabs[currentTab].classList.remove("active-form-tab");
        currentTab = currentTab + n;
        tabs[currentTab].classList.add("active-form-tab");
        showTab(currentTab);
    }

    function validateForm() {
        var tabs, activeTab, valid = true;
        tabs = document.getElementsByClassName("tab");
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid;
    }

    document.addEventListener('change', function () {
        var inputsActiveTab = document.querySelectorAll("#AsproForm .active-form-tab input[required]")
        console.log(inputsActiveTab)
        for (i = 0; i < inputsActiveTab.length; i++) {
            console.log(inputsActiveTab[i].value)
            if (inputsActiveTab[i].value != "") {
                inputsActiveTab[i].classList.remove("error-cloud");
            }
        }
    })

</script>