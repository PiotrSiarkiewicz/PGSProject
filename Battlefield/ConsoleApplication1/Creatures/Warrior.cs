using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ConsoleApplication1.Creatures
{
    class Warrior : Creature
    {
        public Warrior(int xLimit, int yLimit) 
            : base(xLimit, yLimit, 'R', ConsoleColor.Green)
        {
            _health += _health/10;
        }

        public override int Attack()
        {
            AdrenalinaRush();
            return _power;
        }

        private void AdrenalinaRush()
        {
            _power += 3;
        }

    }
}
