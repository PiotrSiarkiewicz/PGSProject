using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using ConsoleApplication1.Creatures;

namespace ConsoleApplication1
{
    class World
    {
        private Random _rnd;
        private int _windowsHeight;
        private int _windowWidth;
        private List<Creature> _creatureList;
        private int _wizardCount;
        private int _warriorCount;
        private int _thiefCount;
        private int _warlockCount ;
        public World(int windowsHeight = 20, int windowsWidth = 40)
        {
            _rnd = new Random();
            Console.WindowHeight = windowsHeight;
            Console.WindowWidth = windowsWidth;
            _windowsHeight = windowsHeight - 1;
            _windowWidth = windowsWidth;
            CreateCreatureList();
        }

        private void CreateCreatureList()
        {
           _creatureList = new List<Creature>();
            int amountOfCreatures = _windowsHeight*_windowWidth*15/100;
            for (int i = 0; i < amountOfCreatures /  3 ; i++)
            {
                _creatureList.Add(new Thief(_windowWidth,_windowsHeight));
                _creatureList.Add(new Wizard(_windowWidth, _windowsHeight));
                _creatureList.Add(new Warrior(_windowWidth, _windowsHeight));
                _creatureList.Add(new Warlock(_windowWidth, _windowsHeight));
            }
            foreach (var creature in _creatureList)
            {
                RandAndSetCoordinantes(creature);
            }
        }

        private void RandAndSetCoordinantes(Creature creature)
        {
            int coordX, coordY;
            do
            {
                coordX = _rnd.Next(0,_windowWidth);
                coordY = _rnd.Next(0, _windowsHeight);
            } while (_creatureList.Exists(x=>x.XCoordinate == coordX && x.YCoordinate == coordY));
            creature.XCoordinate = coordX;
            creature.YCoordinate = coordY;

        }

        private void DisplayFieldOfBattle()
        {
            foreach (var creature in _creatureList)
            {
                Console.ForegroundColor = creature.Color;
                Console.SetCursorPosition(creature.XCoordinate,creature.YCoordinate);
                Console.Write(creature.Symbol);
                
                
                Console.ResetColor();
                creature.Move();
            }
            DisplayStats();

        }

        private void DisplayStats()
        {
            Console.SetCursorPosition(1, Console.WindowHeight);
            Console.ForegroundColor = ConsoleColor.White;
             CountOfChampions();

            Console.WriteLine($"W: {_wizardCount}, T {_thiefCount}, R {_warriorCount} L {_warlockCount}" );
        }

        private void CountOfChampions()
        {
            _wizardCount = _creatureList.Count(w => w.Symbol == 'W');
            _warriorCount = _creatureList.Where(r => r.Symbol == 'R').Count();
            _thiefCount = _creatureList.Count(w => w.Symbol == 'T');
            _warlockCount = _creatureList.Count(w => w.Symbol == 'L');
        }


        private void TimeToBattle()
        {
            Console.Clear();

            DisplayFieldOfBattle();

            for (int i = _creatureList.Count -1 ; i > 0; --i)
            {
                

                if ( _creatureList[i].IsAlive() )
                {
                    if (SomeoneStillAlive())
                    {
                        Fight(_creatureList[RollEnemy(i)], _creatureList[i]);
                    }
                    
                            
                }
                
                

            }
            ThrowOutBodies();

        }

        private int RollEnemy(int i)
        {
            int idx;
            do
            {
                idx = _rnd.Next(0, _creatureList.Count-1);

            } while (!_creatureList[idx].IsAlive()
                     && idx == i
                     && _creatureList[idx].GetType() == _creatureList[i].GetType());
            return idx;
        }

    

        private void Fight(Creature creature, Creature creature1)
        {
            
                creature.GetDamage(creature1.Attack());
                creature1.GetDamage(creature.Attack());
                
            
        }

        private void ThrowOutBodies()
        {
            for (int i = _creatureList.Count - 1; i >= 0; i--)
            {
                if (_creatureList[i].IsAlive() == false)
                {
                    _creatureList.RemoveAt(i);
                }
               
            }
        }

        public void LastManStanding()
        {

            do
            {

                Thread.Sleep(1500);
                TimeToBattle();
            } while (SomeoneStillAlive());
            Champions();

        }

        private void Champions()
        {
            Console.Clear();
            
            Console.WriteLine("The Champion is: ");
            
            Console.Write(_creatureList.First().Symbol);
        }

        private bool SomeoneStillAlive()
        {
            int count=0;
            CountOfChampions();
            
            if (_thiefCount == 0) count++;
            if (_wizardCount == 0) count++;
            if (_warriorCount == 0) count++;
            if (_warlockCount == 0) count++;

            if (count >= 3)
            {
                return false;
            }
            else
            {
                return true;
            }
                
            
        }
    }
}
