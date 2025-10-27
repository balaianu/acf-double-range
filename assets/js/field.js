(function ($) {
  /**
   * ACF Double Range Field – Live validation + stable cursor
   * - Real-time clamping during typing
   * - No cursor jumps
   * - Rounds & syncs on blur/change
   */
  var DoubleRange = acf.Field.extend({
    type: 'double_range',

    events: {
      'input .double-range-min':  'onMinInput',
      'input .double-range-max':  'onMaxInput',
      'blur .double-range-min':   'onCommit',
      'blur .double-range-max':   'onCommit',
      'change .double-range-min': 'onCommit',
      'change .double-range-max': 'onCommit'
    },

    // Shortcuts
    $wrap()   { return this.$('.acf-double-range'); },
    $slider() { return this.$('.double-slider'); },
    $min()    { return this.$('.double-range-min'); },
    $max()    { return this.$('.double-range-max'); },

    getLimits() {
      const $w = this.$wrap();
      return {
        min:  parseFloat($w.data('min'))  || 0,
        max:  parseFloat($w.data('max'))  || 100,
        step: parseFloat($w.data('step')) || 1
      };
    },

    initialize() {
      this.waitForVisible(() => this.build());
    },

    waitForVisible(next) {
      const $s = this.$slider();
      let tries = 0;
      const tick = () => {
        tries++;
        if ($s[0] && $s[0].offsetWidth > 10) return next();
        if (tries > 80) return next();
        requestAnimationFrame(tick);
      };
      tick();
    },

    build() {
      const $s = this.$slider();
      const $minI = this.$min();
      const $maxI = this.$max();
      if (!$s.length) return;

      if ($s.hasClass('ui-slider')) $s.slider('destroy');

      if (typeof $.fn.slider !== 'function' && typeof window.jQuery?.fn?.slider === 'function') {
        $.fn.slider = window.jQuery.fn.slider;
      }
      if (typeof $.fn.slider !== 'function') return;

      const { min, max, step } = this.getLimits();
      let startMin = parseFloat($minI.val());
      let startMax = parseFloat($maxI.val());
      if (!isFinite(startMin)) startMin = min;
      if (!isFinite(startMax)) startMax = max;

      startMin = this.clamp(startMin, min, max);
      startMax = this.clamp(startMax, min, max);
      if (startMax < startMin) startMax = startMin;

      $s.slider({
        range: true,
        min, max, step,
        values: [startMin, startMax],
        slide: (_e, ui) => {
          $minI.val(ui.values[0]);
          $maxI.val(ui.values[1]);
        },
        stop: (_e, ui) => {
          $minI.val(this.round(ui.values[0]));
          $maxI.val(this.round(ui.values[1]));
        }
      });

      $minI.val(this.round(startMin));
      $maxI.val(this.round(startMax));
    },

    /** Live validation on typing **/
    onMinInput() {
      const $s = this.$slider();
      if (!$s.length || !$s.hasClass('ui-slider')) return;

      const { min, max } = this.getLimits();
      const $minI = this.$min();
      const $maxI = this.$max();

      let a = parseFloat($minI.val());
      let b = parseFloat($maxI.val());

      if (!isFinite(a)) return;
      if (!isFinite(b)) b = max;

      // Clamp live while typing
      if (a < min) {
        a = min;
        $minI.val(a); // apply only when truly out of range
      }
      if (a > b) {
        a = b;
        $minI.val(a);
      }

      $s.slider('values', 0, a);
    },

    onMaxInput() {
      const $s = this.$slider();
      if (!$s.length || !$s.hasClass('ui-slider')) return;

      const { min, max } = this.getLimits();
      const $minI = this.$min();
      const $maxI = this.$max();

      let a = parseFloat($minI.val());
      let b = parseFloat($maxI.val());

      if (!isFinite(a)) a = min;
      if (!isFinite(b)) return;

      // Clamp live while typing
      if (b > max) {
        b = max;
        $maxI.val(b);
      }
      if (b < a) {
        b = a;
        $maxI.val(b);
      }

      $s.slider('values', 1, b);
    },

    /** Final validation + rounding **/
    onCommit(e) {
      const $input = $(e.currentTarget);
      const $s = this.$slider();
      const { min, max } = this.getLimits();
      const $minI = this.$min();
      const $maxI = this.$max();

      let a = parseFloat($minI.val());
      let b = parseFloat($maxI.val());
      if (!isFinite(a)) a = min;
      if (!isFinite(b)) b = max;

      // Clamp and ensure order
      a = this.clamp(a, min, b);
      b = this.clamp(b, a, max);

      // Round now (safe cursor state)
      $minI.val(this.round(a));
      $maxI.val(this.round(b));

      if ($s.length && $s.hasClass('ui-slider')) {
        $s.slider('values', [a, b]);
      }
    },

    /** Utility **/
    round(v) { return isFinite(v) ? Number(v).toFixed(2) : ''; },
    clamp(v, min, max) {
      if (!isFinite(v)) return min;
      return Math.min(Math.max(v, min), max);
    }
  });

  acf.registerFieldType(DoubleRange);
})(jQuery);
