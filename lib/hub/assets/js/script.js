document.addEventListener('DOMContentLoaded', function() {
    const questions = document.querySelectorAll('.schema-faq-question');
    
    questions.forEach(question => {
        question.addEventListener('click', function() {
            // Toggle active class on question
            this.classList.toggle('active');
            
            // Toggle show class on answer
            const answer = this.nextElementSibling;
            answer.classList.toggle('show');
        });
    });
});