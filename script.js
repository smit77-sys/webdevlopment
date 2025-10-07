// Image slider functionality
const images = [
  {
    src: "https://d13loartjoc1yn.cloudfront.net/upload/institute/images/large/121123122228_Emergence_of_CHARUSAT___top_image.webp",
    alt: "CHARUSAT Main Campus",
  },
  {
    src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSh2_AAYnPWUk_abQk77FOhtrwxltfUN9XONw&s",
    alt: "CHARUSAT Library",
  },
  {
    src: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgJMZWGEa5fhgEJAbFTq3P8mgBr-VIPQr1Vw&s",
    alt: "CHARUSAT Logo Building",
  },
]

let currentImageIndex = 0
let autoSlideInterval
let isPopupOpen = false

// Utility Functions
function formatTime(dateString) {
  const date = new Date(dateString)
  return date.toLocaleString("en-US", {
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  })
}

// Typewriter effect for welcome popup
function typeWriter(text, element, speed = 100) {
  let i = 0
  element.textContent = ""

  function type() {
    if (i < text.length) {
      element.textContent += text.charAt(i)
      i++
      setTimeout(type, speed)
    }
  }

  type()
}

// Show welcome popup with typewriter effect
function showWelcomePopup() {
  if (isPopupOpen) return // Prevent multiple popups

  const popup = document.getElementById("welcome-popup")
  const typewriterText = document.getElementById("typewriter-text")
  const welcomeText = "Welcome to CHARUSAT University"

  popup.style.display = "flex"
  isPopupOpen = true

  // Start typewriter effect after a short delay
  setTimeout(() => {
    typeWriter(welcomeText, typewriterText, 80)
  }, 500)
}

// Close welcome popup
function closeWelcomePopup() {
  const popup = document.getElementById("welcome-popup")
  popup.style.animation = "fadeOut 0.3s ease-out"

  setTimeout(() => {
    popup.style.display = "none"
    popup.style.animation = ""
    isPopupOpen = false
  }, 300)
}

// FAQ toggle functionality
function toggleFaq(faqId) {
  const faqContent = document.getElementById(faqId)
  const faqButton = faqContent.previousElementSibling
  const faqIcon = faqButton.querySelector(".faq-icon")
  const isActive = faqContent.classList.contains("active")

  // Close all FAQ items
  const allFaqContents = document.querySelectorAll(".faq-content")
  const allFaqIcons = document.querySelectorAll(".faq-icon")

  allFaqContents.forEach((content) => {
    content.classList.remove("active")
  })

  allFaqIcons.forEach((icon) => {
    icon.textContent = "+"
    icon.style.transform = "rotate(0deg)"
  })

  // Open clicked FAQ if it wasn't already active
  if (!isActive) {
    faqContent.classList.add("active")
    faqIcon.textContent = "−"
    faqIcon.style.transform = "rotate(180deg)"
  }
}

// Image slider functions
function showImage(index) {
  const sliderImage = document.getElementById("slider-image")
  const dots = document.querySelectorAll(".dot")
  const currentImageSpan = document.getElementById("current-image")

  // Update image
  sliderImage.src = images[index].src
  sliderImage.alt = images[index].alt

  // Update dots
  dots.forEach((dot, i) => {
    dot.classList.toggle("active", i === index)
  })

  // Update counter
  currentImageSpan.textContent = index + 1

  currentImageIndex = index
}

function nextImage() {
  currentImageIndex = (currentImageIndex + 1) % images.length
  showImage(currentImageIndex)
  resetAutoSlide()
}

function prevImage() {
  currentImageIndex = (currentImageIndex - 1 + images.length) % images.length
  showImage(currentImageIndex)
  resetAutoSlide()
}

function currentSlide(index) {
  showImage(index)
  resetAutoSlide()
}

// Auto-slide functionality
function startAutoSlide() {
  autoSlideInterval = setInterval(() => {
    nextImage()
  }, 5000) // Change image every 5 seconds
}

function resetAutoSlide() {
  clearInterval(autoSlideInterval)
  startAutoSlide()
}

// User authentication functions
function checkUserLogin() {
  const isLoggedIn = localStorage.getItem("isLoggedIn")
  const userEmail = localStorage.getItem("userEmail")
  const loginTime = localStorage.getItem("loginTime")

  if (isLoggedIn === "true" && userEmail) {
    // Show user info
    const userInfo = document.getElementById("user-info")
    const welcomeMessage = document.getElementById("welcome-message")
    const loginTimeElement = document.getElementById("login-time")
    const loginLink = document.getElementById("login-link")
    const logoutBtn = document.getElementById("logout-btn")

    if (userInfo && welcomeMessage && loginLink && logoutBtn) {
      userInfo.style.display = "flex"
      welcomeMessage.textContent = `Welcome, ${userEmail}`

      if (loginTime && loginTimeElement) {
        loginTimeElement.textContent = `Logged in: ${formatTime(loginTime)}`
      }

      loginLink.style.display = "none"
      logoutBtn.style.display = "inline-block"
    }

    return true
  }

  return false
}

function logout() {
  // Show confirmation dialog
  const confirmLogout = confirm("Are you sure you want to logout?")

  if (confirmLogout) {
    // Clear user session
    localStorage.removeItem("isLoggedIn")
    localStorage.removeItem("userEmail")
    localStorage.removeItem("loginTime")

    // Show logout message
    alert("You have been logged out successfully!")

    // Reload the page to reset the UI
    window.location.reload()
  }
}

// Initialize page
document.addEventListener("DOMContentLoaded", () => {
  // Check if user is logged in
  checkUserLogin()

  // Initialize image slider
  showImage(0)
  const totalImagesSpan = document.getElementById("total-images")
  if (totalImagesSpan) {
    totalImagesSpan.textContent = images.length
  }

  // Start auto-slide
  startAutoSlide()

  // Event listeners
  const logoutBtn = document.getElementById("logout-btn")
  if (logoutBtn) {
    logoutBtn.addEventListener("click", (e) => {
      e.preventDefault()
      logout()
    })
  }

  // Welcome popup button event listener
  const showWelcomeBtn = document.getElementById("show-welcome-btn")
  if (showWelcomeBtn) {
    showWelcomeBtn.addEventListener("click", showWelcomePopup)
  }

  // Welcome popup event listeners
  const closePopupBtn = document.getElementById("close-popup")
  const exploreBtn = document.getElementById("explore-btn")

  if (closePopupBtn) {
    closePopupBtn.addEventListener("click", closeWelcomePopup)
  }

  if (exploreBtn) {   
    exploreBtn.addEventListener("click", closeWelcomePopup)
  }

  // Close popup when clicking outside
  const popupOverlay = document.getElementById("welcome-popup")
  if (popupOverlay) {
    popupOverlay.addEventListener("click", (e) => {
      if (e.target === popupOverlay) {
        closeWelcomePopup()
      }
    })
  }

  // Pause auto-slide when user hovers over slider
  const sliderContainer = document.querySelector(".slider-container")
  if (sliderContainer) {
    sliderContainer.addEventListener("mouseenter", () => {
      clearInterval(autoSlideInterval)
    })

    sliderContainer.addEventListener("mouseleave", () => {
      startAutoSlide()
    })
  }
})

// Keyboard navigation for image slider and popup
document.addEventListener("keydown", (event) => {
  if (isPopupOpen) {
    if (event.key === "Escape") {
      closeWelcomePopup()
    }
    return // Don't handle other keys when popup is open
  }

  if (event.key === "ArrowLeft") {
    prevImage()
  } else if (event.key === "ArrowRight") {
    nextImage()
  }
})

// Handle page visibility change (pause auto-slide when tab is not active)
document.addEventListener("visibilitychange", () => {
  if (document.hidden) {
    clearInterval(autoSlideInterval)
  } else {
    if (!isPopupOpen) {
      startAutoSlide()
    }
  }
})

// Add CSS for fadeOut animation
const style = document.createElement("style")
style.textContent = `
  @keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
  }
`
document.head.appendChild(style)
