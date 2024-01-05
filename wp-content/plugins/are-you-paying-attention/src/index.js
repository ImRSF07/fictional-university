wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
  title: 'Are you paying attention?',
  icon: 'smiley',
  category: 'common',
  attributes: {
    skyColor: {
      type: 'string',
    },
    grassColor: {
      type: 'string',
    },
  },
  edit: function (props) {
    const updateSkyColor = (e) => {
      props.setAttributes({ skyColor: e.target.value });
    };
    const updateGrassColor = (e) => {
      props.setAttributes({ grassColor: e.target.value });
    };
    return (
      <>
        <input
          type='text'
          placeholder='Sky color'
          value={props.attributes.skyColor}
          onChange={updateSkyColor}
        />
        <input
          type='text'
          placeholder='Grass color'
          value={props.attributes.grassColor}
          onChange={updateGrassColor}
        />
      </>
    );
  },
  save: function (props) {
    return null;
  },
});
