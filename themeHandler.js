  const translations = {
    "EN": {
        "label_dark_mode": "Dark Mode",
        "header_sign_up": "Sign up",
        "input_first_name": "First Name",
        "input_last_name": "Last Name",
        "input_email": "Email",
        "input_phone_number": "Phone Number",
        "input_date_of_birth": "Date of Birth",
        "input_password": "Password",
        "input_confirm_password": "Confirm Password",
        "button_submit": "Submit",
        "login_title": "Login",
        "input_email_placeholder": "Email",
        "input_password_placeholder": "Password",
        "button_login": "Login",
        "label_why_programmers": "Why do programmers",
        "phrase_drink_coffee": "drink a lot of coffee",
        "phrase_fix_printers": "often get asked to fix printers",
        "phrase_listen_to_music": "listen to music while they code",
        "phrase_prefer_dark_mode": "prefer dark mode over light mode",
        "phrase_hate_interruptions": "hate interruptions during coding",
        "phrase_love_optimizing": "love optimizing and refactoring code",
        "button_log_in": "Log in",
        "button_sign_up": "Sign up",
        "button_confirm": "Confirm",
        "button_back": "Back",
        "button_newchat": "New Chat",
        "button_setting": "Setting",
        "edit_title": "Edit profile",
        "button_yes": "YES",
        "button_no": "NO",
        "delete_title": "Are you sure you want to delete your account?",
        "s_first_name": "First Name: ",
        "s_last_name": "Last Name: ",
        "s_email": "Email: ",
        "s_phone_number": "Phone Number: ",
        "s_date_of_birth": "Date of Birth: ",
        "delete_button": "Delete Account",
        "edit_titles": "Edit Profile",
        "header_new_page": "Profile",
      },
      "TH": {
        "label_dark_mode": "โหมดกลางคืน",
        "header_sign_up": "ลงทะเบียน",
        "input_first_name": "ชื่อจริง",
        "input_last_name": "นามสกุล",
        "input_email": "อีเมล",
        "input_phone_number": "หมายเลขโทรศัพท์",
        "input_date_of_birth": "วันเกิด",
        "input_password": "รหัสผ่าน",
        "input_confirm_password": "ยืนยันรหัสผ่าน",
        "button_submit": "ส่ง",
        "login_title": "เข้าสู่ระบบ",
        "input_email_placeholder": "อีเมล",
        "input_password_placeholder": "รหัสผ่าน",
        "button_login": "เข้าสู่ระบบ",
        "label_why_programmers": "ทำไมโปรแกรมเมอร์ถึง",
        "phrase_drink_coffee": "ดื่มกาแฟมาก",
        "phrase_fix_printers": "มักจะถูกขอให้ซ่อมเครื่องพิมพ์",
        "phrase_listen_to_music": "ฟังเพลงขณะที่เขียนโค้ด",
        "phrase_prefer_dark_mode": "ชอบโหมดกลางคืนมากกว่าโหมดแสงสว่าง",
        "phrase_hate_interruptions": "ไม่ชอบการถูกรบกวนขณะเขียนโค้ด",
        "phrase_love_optimizing": "ชอบการปรับปรุงและโครงสร้างโค้ดใหม่",
        "button_log_in": "เข้าสู่ระบบ",
        "button_sign_up": "ลงทะเบียน",
        "button_confirm": "คอนเฟิร์ม",
        "button_back": "กลับ",
        "button_newchat": "แชทใหม่",
        "button_setting": "ตั้งค่า",
        "edit_title": "แก้ไขโปรไฟล์",
        "button_yes": "ใช่",
        "button_no": "ไม่",
        "delete_title": "คุณแน่ใจใช่ไหมว่าจะลบบัญชีผู้ใช้ของคุณ?",
        "s_first_name": "ชื่อจริง: ",
        "s_last_name": "นามสกุล: ",
        "s_email": "อีเมล: ",
        "s_phone_number": "หมายเลขโทรศัพท์: ",
        "s_date_of_birth": "วันเกิด: ",
        "delete_button": "ลบบัญชีผู้ใช้",
        "edit_titles": "แก้ไขโปรไฟล์",
        "header_new_page": "โปรไฟล์",
      }
  };

// Applies the selected theme to the document body and all elements with the 'card' class
function applyTheme(theme) {
    const isDarkMode = theme === 'dark'; // Check if the theme is 'dark'
    document.body.classList.toggle('dark-mode', isDarkMode); // Toggle 'dark-mode' class on body
    document.querySelectorAll('.card').forEach(card => { // For each '.card' element
      card.classList.toggle('dark-mode', isDarkMode); // Toggle 'dark-mode' class
    });
  }
  
  // Toggles between 'light' and 'dark' theme
  function toggleTheme() {
    // Determine new theme based on the presence of 'dark-mode' class on the body
    const newTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
    applyTheme(newTheme); // Apply the new theme
    localStorage.setItem('theme', newTheme); // Store the new theme in localStorage
  }
  
  // Updates the text content of the page elements based on the selected language
  function updateTextContent(language) {
    // Iterate over each translation key in the selected language
    Object.keys(translations[language]).forEach(key => {
      const element = document.getElementById(key); // Get the element by translation key as ID
      if (element) { // If element exists
        // Check if it's an input element (excluding submit buttons)
        if (element.tagName === 'INPUT' && element.type !== 'submit') {
          element.placeholder = translations[language][key]; // Set its placeholder
        } else {
          element.textContent = translations[language][key]; // Set its text content
        }
      }
    });
  }
  
  // Sets the current language and updates the page content and local storage
  function setLanguage(language) {
    updateTextContent(language); // Update text content to the selected language
    localStorage.setItem('language', language); // Store the selected language in localStorage
    // Update language toggle buttons to reflect current language
    document.querySelectorAll('[id^="btn-language-"]').forEach(button => {
      button.textContent = button.id.split('-').pop().toUpperCase(); // Set the button text
    });
  }
  
  // Initializes the page with the saved theme and language settings
  function initializePage() {
    const savedTheme = localStorage.getItem('theme') || 'light'; // Get saved theme or default to 'light'
    applyTheme(savedTheme); // Apply the saved or default theme
  
    const savedLanguage = localStorage.getItem('language') || 'EN'; // Get saved language or default to 'EN'
    setLanguage(savedLanguage); // Set the saved or default language
    
    // Set the dark mode toggle state based on the saved theme
    if (darkModeToggle) {
      darkModeToggle.checked = savedTheme === 'dark';
    }
  }
  
  // Default language to be used before any selection is made
  let currentLanguage = localStorage.getItem('language') || 'EN';
  // Get the dark mode toggle switch element
  const darkModeToggle = document.getElementById("darkModeToggle");
  
  // Attach event listeners to language toggle buttons
  document.getElementById('btn-language-th').addEventListener('click', () => setLanguage('TH'));
  document.getElementById('btn-language-en').addEventListener('click', () => setLanguage('EN'));
  
  // If darkModeToggle is present, attach an event listener to it
  if (darkModeToggle) {
    darkModeToggle.addEventListener('change', toggleTheme);
  }
  
  // Once the DOM is fully loaded, initialize the page settings
  document.addEventListener('DOMContentLoaded', initializePage);