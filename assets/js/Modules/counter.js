/**
 *
 * @param elem
 * @param data
 */
function countDown(elem, data) {
    const second = $(elem).attr('data-time');
    $(elem).FlipClock(second, data);
}