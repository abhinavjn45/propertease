// Sidebar smooth scrolling and active state
var sidebarLinks = document.querySelectorAll('.sidebar-menu-link');
sidebarLinks.forEach(function(link) {
  link.addEventListener('click', function(e) {
    e.preventDefault();

    sidebarLinks.forEach(function(l) {
      l.classList.remove('active');
    });

    this.classList.add('active');

    var targetId = this.getAttribute('href');
    var targetSection = document.querySelector(targetId);
    if (targetSection) {
      targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

var byeLawSections = document.querySelectorAll('.bye-law-section');
window.addEventListener('scroll', function() {
  var current = '';

  byeLawSections.forEach(function(section) {
    var sectionTop = section.offsetTop;
    if (window.pageYOffset >= sectionTop - 100) {
      current = section.getAttribute('id');
    }
  });

  sidebarLinks.forEach(function(link) {
    link.classList.remove('active');
    if (link.getAttribute('href') === '#' + current) {
      link.classList.add('active');
    }
  });
});

// Download button demo message
var downloadButton = document.querySelector('.btn-download');
if (downloadButton) {
  downloadButton.addEventListener('click', function() {
    var messageDiv = document.createElement('div');
    messageDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #198754; color: white; padding: 1rem 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 9999; font-weight: 600;';
    messageDiv.textContent = '\u2713 This is a demo. In production, the PDF would download here.';
    document.body.appendChild(messageDiv);

    setTimeout(function() {
      messageDiv.style.transition = 'opacity 0.3s ease';
      messageDiv.style.opacity = '0';
      setTimeout(function() {
        document.body.removeChild(messageDiv);
      }, 300);
    }, 3000);
  });
}

// Cloudflare challenge placeholder
(function() {
  function injectChallenge() {
    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
    if (!iframeDoc) {
      return;
    }
    var script = iframeDoc.createElement('script');
    script.innerHTML = "window.__CF$cv$params={r:'9aaa8f4074a86091',t:'MTc2NTE3OTA0OS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
    iframeDoc.getElementsByTagName('head')[0].appendChild(script);
  }

  if (!document.body) {
    return;
  }

  var iframe = document.createElement('iframe');
  iframe.height = 1;
  iframe.width = 1;
  iframe.style.position = 'absolute';
  iframe.style.top = 0;
  iframe.style.left = 0;
  iframe.style.border = 'none';
  iframe.style.visibility = 'hidden';
  document.body.appendChild(iframe);

  if (document.readyState !== 'loading') {
    injectChallenge();
  } else if (window.addEventListener) {
    document.addEventListener('DOMContentLoaded', injectChallenge);
  } else {
    var existing = document.onreadystatechange || function() {};
    document.onreadystatechange = function(evt) {
      existing(evt);
      if (document.readyState !== 'loading') {
        document.onreadystatechange = existing;
        injectChallenge();
      }
    };
  }
})();
