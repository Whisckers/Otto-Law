
document.addEventListener("DOMContentLoaded", () => {
  // Select all paragraphs, lists, list items, and images
  const floatElements = document.querySelectorAll("p, ul, li, img");

  // Add the float-down class to each element
  floatElements.forEach(el => el.classList.add("float-down"));

  // Observer to trigger animation when visible
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  }, { threshold: 0.2 });

  floatElements.forEach(el => observer.observe(el));
});

